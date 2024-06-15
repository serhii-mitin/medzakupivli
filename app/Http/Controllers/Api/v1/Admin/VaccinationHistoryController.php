<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VaccinationHistory;
use App\Services\Api\v1\Admin\PatientVaccinationHistoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class VaccinationHistoryController extends Controller
{
    public function __construct(protected readonly PatientVaccinationHistoryService $service)
    {
    }

    #[OA\Get(
        path: "/api/admin/patients/{patient_id}/vaccination-history",
        summary: "Single Patient",
        tags: ["Admin/Patients/VaccinationHistory"],
        parameters: [
            new OA\PathParameter(
                name: 'patient_id',
                required: true,
                in: 'path',
                schema: new OA\Schema(type: 'integer', default: '1')
            )
        ],
        security: [
            ["Bearer" => []]
        ],
        responses: [
            new OA\Response(response: JsonResponse::HTTP_OK, description: "the list")
        ]
    )]
    public function index(User $patient): JsonResource
    {
        $collection = $this->service->getList($patient);

        return JsonResource::make($collection);
    }

    #[OA\Post(
        path: "/api/admin/patients/{patient_id}/vaccination-history/{vh_id}/cancel",
        summary: "Single Patient",
        tags: ["Admin/Patients/VaccinationHistory"],
        parameters: [
            new OA\PathParameter(
                name: 'patient_id',
                required: true,
                in: 'path',
                schema: new OA\Schema(type: 'integer', default: '1')
            ),
            new OA\PathParameter(
                name: 'vh_id',
                required: true,
                in: 'path',
                schema: new OA\Schema(type: 'integer', default: '1')
            )
        ],
        security: [
            ["Bearer" => []]
        ],
        responses: [
            new OA\Response(response: JsonResponse::HTTP_OK, description: "the list")
        ]
    )]
    public function cancel(User $patient, VaccinationHistory $history): JsonResponse
    {
        $this->authorize('cancel', [$history, $patient]);

        $resultData = $this->service->delete($history);

        return response()->json($resultData->toArray(), $resultData->response_status);
    }
}
