<?php
namespace App\Traits;

use Illuminate\Support\Facades\Config;

trait ApiResponse{

    private function successResponse($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {

        return response()->json([
            'code' => $code,
            'error' => $message,
        ],$code);
    }

    protected function showAll($collection, $code = 200)
    {

        if (!empty($collection)) {
            return $this->successResponse([
                'code' => $code,
                'data' => $collection
            ], $code);
        }
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse([
            'code' => $code,
            'message' => $message,
        ], $code);
    }


    protected function exceptionError(){
        return response()->json([
            'code' => Config::get('constants.STATUS_ERROR'),
            'error' => 'Internal Server Error',
        ],500);
    }

}
