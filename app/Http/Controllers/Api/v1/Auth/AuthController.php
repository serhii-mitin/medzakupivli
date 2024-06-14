<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\LoginRequest;
use App\Http\Resources\Api\v1\Auth\AuthResource;
use App\Models\User;
use App\Utils\Enums\User\UserEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{

    #[OA\Post(
        path: "/api/auth/login",
        summary: "Auth Login",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ["email", "password"],
                    properties: [
                        new OA\Property(
                            property: 'email',
                            type: "string",
                            default: ''
                        ),
                        new OA\Property(
                            property: 'password',
                            type: "string",
                            default: ''
                        )
                    ]
                )
            )
        ),
        security: [
            ["Bearer" => []]
        ],
        responses: [
            new OA\Response(response: JsonResponse::HTTP_OK, description: "Success"),
            new OA\Response(response: JsonResponse::HTTP_UNPROCESSABLE_ENTITY, description: "Incorrect login data")
        ]
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::query()
            ->whereEmail(Str::lower($request->email))
            ->first();

        if (!$user || !auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => __('auth.failed'),
                'errors' => [
                    'email' => [''],
                    'password' => [__('auth.login_wrong')]
                ]
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response_json_data(
            $this->respondWithToken(
                auth()->user()->createToken(UserEnum::API_TOKEN_NAME)
            )
        );
    }

    protected function respondWithToken(NewAccessToken $token): array
    {
        return [
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer'
        ];
    }

    #[OA\Get(
        path: "/api/auth/me",
        summary: "me",
        tags: ["Auth"],
        security: [
            ["Bearer" => []]
        ],
        responses: [
            new OA\Response(response: JsonResponse::HTTP_OK, description: 'Auth user resource')
        ]
    )]
    public function me()
    {
        $user = auth()
            ->user()
            ->load(['roles']);

        return response_json_data(new AuthResource($user));
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response_json_data();
    }
}
