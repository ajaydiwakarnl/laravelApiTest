<?php


namespace App\Traits;


trait ApiResponse
{

    /**
     * @param $data
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public  function  success($data, string $message , int $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json(array_filter([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]));
    }

    public  function  error(string $message , int $code = 422,$data=null): \Illuminate\Http\JsonResponse
    {
        return response()->json(array_filter([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]));
    }



}
