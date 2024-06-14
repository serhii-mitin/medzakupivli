<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\MedicalFacility\MedicalFacilityListRequest;
use App\Http\Resources\Api\v1\Admin\MedicalFacility\MedicalFacilityListResource;
use App\Http\Resources\Api\v1\Admin\MedicalFacility\MedicalFacilityResource;
use App\Models\MedicalFacility;
use App\Services\Api\v1\MedicalFacilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class MedicalFacilityController extends Controller
{
    public function __construct(protected readonly MedicalFacilityService $service)
    {
    }

    #[OA\Get(
        path: "/api/admin/medical-facilities",
        summary: "Medical Facility list",
        tags: ["Admin/MedicalFacility"],
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
            new OA\Response(response: JsonResponse::HTTP_OK, description: 'the list off medical facilities')
        ]
    )]
    public function index(MedicalFacilityListRequest $request): AnonymousResourceCollection
    {
        $pagination = $this->service->getList($request->validated());

        return MedicalFacilityListResource::collection($pagination);
    }

    #[OA\Get(
        path: "/api/admin/medical-facilities/{id}",
        summary: "Single Medical Facility",
        tags: ["Admin/MedicalFacility"],
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
            new OA\Response(response: JsonResponse::HTTP_OK, description: "the medical facility retrieved success"),
            new OA\Response(response: JsonResponse::HTTP_NOT_FOUND, description: "the medical facility not found")
        ]
    )]
    public function show(MedicalFacility $medicalFacility): MedicalFacilityResource
    {
        return MedicalFacilityResource::make($medicalFacility);
    }
}
