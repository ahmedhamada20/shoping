<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($message, $result)
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data'    => $result,
        ];
        return response()->json($response, 200);
    }

    public function error($message)
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];
        // if (!empty($result)) {
        //     $response['data'] = $result;
        // }
        return response()->json($response, 200);
    }
}
