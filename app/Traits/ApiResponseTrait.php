<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Return a success response with optional data and custom status code.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $statusCode
     */
    public function successResponse($data = null, $message = 'Success', $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Return an error response with optional error data and custom status code.
     *
     * @param  string  $message
     * @param  int  $statusCode
     */
    public function errorResponse($message = 'Error', array $errors = [], $statusCode = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Return a response with pagination data.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $statusCode
     */
    public function paginatedResponse($data, $message = 'Success', $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data->items(),
            'pagination' => [
                'total' => $data->total(),
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'last_page' => $data->lastPage(),
            ],
        ];

        return response()->json($response, $statusCode);
    }
}
