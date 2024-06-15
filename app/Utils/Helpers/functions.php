<?php

use App\Http\ResponseData\Api\v1\AbstractResponseData;
use Illuminate\Http\JsonResponse;

if (!function_exists('response_json_data')) {
    function response_json_data($data = null, string $message = 'OK'): \Illuminate\Http\JsonResponse
    {
        $response = [
            'message' => $message
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response);
    }
}

if (!function_exists('failed_response_data')) {
    function failed_response_data($responseStatus = JsonResponse::HTTP_CONFLICT, ?string $message = null): AbstractResponseData
    {
        return AbstractResponseData::validateAndCreate([
            'response_status' => $responseStatus,
            'message' => $message ?? __('notifications.oops'),
        ]);
    }
}
