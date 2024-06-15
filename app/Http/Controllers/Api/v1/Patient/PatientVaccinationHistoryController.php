<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\VaccinationHistory\GetMedicalFacilitiesRequest;
use App\Http\Requests\Api\v1\VaccinationHistory\GetNotAvailableDatesRequest;
use App\Http\Requests\Api\v1\VaccinationHistory\StoreVaccinationHistoryRequest;
use App\Http\Requests\Api\v1\VaccinationHistory\StoreVaccinationHistoryRequestData;
use App\Http\RequestsData\Api\v1\VaccinationHistory\MedicalFacilitiesRequestData;
use App\Http\RequestsData\Api\v1\VaccinationHistory\NotAvailableDatesRequestData;
use App\Services\Api\v1\Patient\PatientVaccinationHistoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class PatientVaccinationHistoryController extends Controller
{
    public function __construct(protected readonly PatientVaccinationHistoryService $service)
    {
    }

    #[OA\Get(
        path: "/api/vaccination-history/store/get-vaccines",
        summary: "Vaccines list",
        tags: ["Patient/VaccinationHistory"],
        security: [
            ["Bearer" => []]
        ],
        responses: [
            new OA\Response(response: JsonResponse::HTTP_OK, description: 'the list off vaccines')
        ]
    )]
    public function getVaccines(): JsonResource
    {
        $result = $this->service->getAvailableVaccines();

        return JsonResource::make($result);
    }

    #[OA\Get(
        path: "/api/vaccination-history/store/get-medical-facilities",
        summary: "Medical Facilities list",
        tags: ["Patient/VaccinationHistory"],
        security: [
            ["Bearer" => []]
        ],
        parameters: [
            new OA\Parameter(
                name: "vaccine_id",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "integer",
                    default: 1
                ),
                description: "Vaccine id"
            )
        ],
        responses: [
            new OA\Response(response: JsonResponse::HTTP_OK, description: 'the list')
        ]
    )]
    public function getMedicalFacilities(GetMedicalFacilitiesRequest $request): JsonResource
    {
        $requestData = MedicalFacilitiesRequestData::validateAndCreate($request->validated());
        $result = $this->service->getMedicalFacilities($requestData);

        return JsonResource::make($result);
    }

    #[OA\Get(
        path: "/api/vaccination-history/store/get-dates",
        summary: "Dates list",
        tags: ["Patient/VaccinationHistory"],
        security: [
            ["Bearer" => []]
        ],
        parameters: [
            new OA\Parameter(
                name: "vaccine_id",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "integer",
                    default: 1
                ),
                description: "Vaccine id"
            ),
            new OA\Parameter(
                name: "medical_facility_id",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "integer",
                    default: 1
                ),
                description: "Id"
            ),
            new OA\Parameter(
                name: "start_time",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    default: '2024-09-01 10:00:00'
                ),
                description: "Start Time"
            ),
            new OA\Parameter(
                name: "end_time",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    default: '2024-09-01 10:00:00'
                ),
                description: "End Time"
            ),
        ],
        responses: [
            new OA\Response(response: JsonResponse::HTTP_OK, description: 'the list')
        ]
    )]
    public function getNotAvailableDates(GetNotAvailableDatesRequest $request): JsonResource
    {
        $requestData = NotAvailableDatesRequestData::validateAndCreate($request->validated());

        $result = $this->service->getNotAvailableDates($requestData);

        return JsonResource::make($result);
    }

    #[OA\Post(
        path: "/api/vaccination-history/store",
        summary: "Store",
        tags: ["Patient/VaccinationHistory"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ["vaccine_id", "medical_facility_id", "selected_time"],
                    properties: [
                        new OA\Property(
                            property: 'vaccine_id',
                            type: "integer",
                            default: 1
                        ),
                        new OA\Property(
                            property: 'medical_facility_id',
                            type: "integer",
                            default: 1
                        ),
                        new OA\Property(
                            property: 'selected_time',
                            type: "string",
                            default: "2024-06-20 10:00:00"
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
            new OA\Response(response: JsonResponse::HTTP_CONFLICT, description: "Incorrect data"),
            new OA\Response(response: JsonResponse::HTTP_UNPROCESSABLE_ENTITY, description: "Incorrect data")
        ]
    )]
    public function store(StoreVaccinationHistoryRequest $request): JsonResponse
    {
        $requestData = StoreVaccinationHistoryRequestData::validateAndCreate($request->validated());

        $responseData = $this->service->store(auth()->user(), $requestData);

        return response()->json($responseData->toArray(), $responseData->response_status);
    }
}
