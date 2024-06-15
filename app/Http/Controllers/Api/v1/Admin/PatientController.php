<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\Patient\PatientListRequest;
use App\Http\Resources\Api\v1\User\DefaultUserResource;
use App\Models\User;
use App\Services\Api\v1\Admin\PatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class PatientController extends Controller
{
    public function __construct(protected readonly PatientService $service)
    {
    }

    #[OA\Get(
        path: "/api/admin/patients",
        summary: "Patients list",
        tags: ["Admin/Patients"],
        security: [
            ["Bearer" => []]
        ],
        parameters: [
            new OA\Parameter(
                name: "page",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "integer",
                    default: 1
                ),
                description: "Page number for pagination"
            ),
            new OA\Parameter(
                name: "per_page",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "integer",
                    default: 10
                ),
                description: "Number of items per page"
            ),
            new OA\Parameter(
                name: "sort_field",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    default: "id"
                ),
                description: "Sort field"
            ),
            new OA\Parameter(
                name: "filter[search]",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string"
                ),
                description: "Search term"
            )
        ],
        responses: [
            new OA\Response(response: JsonResponse::HTTP_OK, description: 'the list off patients')
        ]
    )]
    public function index(PatientListRequest $request): AnonymousResourceCollection
    {
        $pagination = $this->service->getList($request->validated());

        return DefaultUserResource::collection($pagination);
    }

    #[OA\Get(
        path: "/api/admin/patients/{id}",
        summary: "Single Patient",
        tags: ["Admin/Patients"],
        parameters: [
            new OA\PathParameter(
                name: 'id',
                required: true,
                in: 'path',
                schema: new OA\Schema(type: 'integer', default: '1')
            ),
        ],
        security: [
            ["Bearer" => []]
        ],
        responses: [
            new OA\Response(response: JsonResponse::HTTP_OK, description: "the patient retrieved success"),
            new OA\Response(response: JsonResponse::HTTP_NOT_FOUND, description: "the patient not found")
        ]
    )]
    public function show(User $patient): DefaultUserResource
    {
        return DefaultUserResource::make($patient);
    }
}
