<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\Vaccine\VaccineListRequest;
use App\Http\Resources\Api\v1\Admin\Vaccine\VaccineListResource;
use App\Http\Resources\Api\v1\Admin\Vaccine\VaccineResource;
use App\Models\Vaccine;
use App\Services\Api\v1\VaccineService;
use Illuminate\Http\JsonResponse;
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
        responses: [
            new OA\Response(response: JsonResponse::HTTP_OK, description: 'the list off vaccines')
        ]
    )]
    public function index(VaccineListRequest $request)
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
