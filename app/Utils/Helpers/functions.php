<?php

if (!function_exists('response_json_data')) {
    /**
     * @param $data
     * @param string $message
     * @return array
     */
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
