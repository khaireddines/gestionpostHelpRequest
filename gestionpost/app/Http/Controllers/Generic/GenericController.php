<?php

namespace App\Http\Controllers\Generic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Status;

class GenericController extends Controller
{

    public function StatusListing()
    {

        try {

            $obj_status = new Status();
            $data = $obj_status->ListStates();

            return response()->json([
                'status' => Config::get('constants.STATUS_OK'),
                'response' => $data]);


        } catch (\Exception $e) {
            $message = trans('lang.systemError');
            $status = Config::get('constants.STATUS_ERROR');

            return response()->json([
                'status' => $status,
                'response' => $message]);
        }

    }

}
