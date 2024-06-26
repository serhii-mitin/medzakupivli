<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\Vaccine\VaccineListRequest;
use App\Http\Resources\Api\v1\Admin\Vaccine\VaccineListResource;
use App\Http\Resources\Api\v1\Admin\Vaccine\VaccineResource;
use App\Models\Vaccine;
use App\Services\Api\v1\Admin\VaccineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class VaccineController extends Controller
{
    public function __construct(protected readonly VaccineService $service)
    {
    }


    #[OA\Get(
        path: "/api/admin/vaccines",
        summary: "Vaccines list",
        tags: ["Admin/Vaccines"],
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
            new OA\Response(response: JsonResponse::HTTP_OK, description: 'the list off vaccines')
        ]
    )]
    public function index(VaccineListRequest $request): AnonymousResourceCollection
    {
        $pagination = $this->service->getList($request->validated());

        return VaccineListResource::collection($pagination);
    }

    #[OA\Get(
        path: "/api/admin/vaccines/{id}",
        summary: "Single Vaccine",
        tags: ["Admin/Vaccines"],
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
            new OA\Response(response: JsonResponse::HTTP_OK, description: "the vaccine retrieved success"),
            new OA\Response(response: JsonResponse::HTTP_NOT_FOUND, description: "the vaccine not found")
        ]
    )]
    public function show(Vaccine $vaccine): VaccineResource
    {
        return VaccineResource::make($vaccine);
    }
}
