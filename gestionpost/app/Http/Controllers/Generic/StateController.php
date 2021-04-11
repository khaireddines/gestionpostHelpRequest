<?php

namespace App\Http\Controllers\Generic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use App\Status;
use App\State;

class StateController extends Controller
{

    public function getStatusAll(){
        try{

            $obj_status = new Status();
            $list=$obj_status->ListStates();

            return response()->json([
                'status' => Config::get('constants.STATUS_OK'),
                'response' => $list]);

        }catch (\Exception $e){
            $message = trans('lang.systemError');
            $status = Config::get('constants.STATUS_ERROR');

            return response()->json([
                'status' => $status,
                'response' => $message]);
        }
    }

    public function getStatusId($id){
        try{

            $obj_status= new Status();
            $list=$obj_status->getListStatusOrder($id);

            return response()->json([
                'status' => Config::get('constants.STATUS_OK'),
                'response' => $list]);


        }catch (\Exception $e){
            $message = trans('lang.systemError');
            $status = Config::get('constants.STATUS_ERROR');

            return response()->json([
                'status' => $status,
                'response' => $message]);
        }
    }

}
