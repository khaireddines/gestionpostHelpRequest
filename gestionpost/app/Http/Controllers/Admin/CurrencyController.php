<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Currency;
use App\Status;


class CurrencyController extends Controller
{

    public function ListCurrencies()
    {
        try {

            $obj_Currency = new Currency();
            $data = $obj_Currency->getCurrency();

            return response()->json([
                'status' => Config::get('constants.STATUS_OK'),
                'response' => $data]);

        } catch (\Exception $e) {

        error_log("hola" . $e);

            $message = trans('lang.systemError');
            $status = Config::get('constants.STATUS_ERROR');

            return response()->json([
                'status' => $status,
                'response' => $message]);
        }
    }


    public function Add(){
        try{

            $obj_status= new Status();
            $data=$obj_status->ListStates();

            return response()->json([
                'status' => Config::get('constants.STATUS_OK'),
                'response' => $data]);

        }catch (\Exception $e){
            $message = trans('lang.systemError');
            $status = Config::get('constants.STATUS_ERROR');

            return response()->json([
                'status' => $status,
                'response' => $message]);
        }
    }

    public function edit(Request $request)
    {

        try {

            $data_post = [
                'id' => $request->id
            ];

            $validator = Validator::make($data_post, [
                'id' => 'required'
            ]);

            if ($validator->fails()) {

                $message = trans('lang.required_fields');
                $status = Config::get('constants.REQUIRED_FIELDS');

                return response()->json([
                    'status' => $status,
                    'response' => $message]);
            } else {

                $obj_Currency = Currency::find($request->id);
                $obj_Status = new Status();

                $id_status = $obj_Currency->id_status;

                $list_status = $obj_Status->getListStatusOrder($id_status);

                $status = Config::get('constants.STATUS_OK');

                return response()->json([
                    'status' => $status,
                    'response' => $obj_Currency,
                    'list_status' => $list_status]);

            }

        } catch (\Exception $e) {
            $message = trans('lang.systemError');
            $status = Config::get('constants.STATUS_ERROR');

            return response()->json([
                'status' => $status,
                'response' => $message]);
        }
    }

    public function insert(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'id_currency' => 'required',
                'symbol' => 'required',
                'description' => 'required',
                'decimal' => 'required',
                'id_status' => 'required'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => Config::get('constants.REQUIRED_FIELDS'),
                    'response' => trans('lang.required_fields')]);

            } else {


                $parameter = [
                    'id_currency' => $request->id_currency,
                    'symbol' => $request->symbol,
                    'description' => $request->description,
                    'decimal' => $request->decimal,
                    'id_status' => $request->id_status
                ];


                $obj_Currency = new Currency();
                $result = $obj_Currency->insertCurrency($parameter);


                if ($result == Config::get('constants.STATUS_OK')) {

                    return response()->json([
                        'status' => Config::get('constants.STATUS_OK'),
                        'response' => trans('lang.saved_data')]);
                } else {

                    return response()->json([
                        'status' => Config::get('constants.STATUS_ERROR'),
                        'response' => trans('lang.insert_error')]);
                }

            }

        } catch (\Exception $e) {
            $message = trans('lang.systemError');
            $status = Config::get('constants.STATUS_ERROR');

            return response()->json([
                'status' => $status,
                'response' => $message]);
        }
    }

    public function update(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'id_currency' => 'required',
                'symbol' => 'required',
                'description' => 'required',
                'decimal' => 'required',
                'id_status' => 'required'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => Config::get('constants.REQUIRED_FIELDS'),
                    'response' => trans('lang.required_fields')]);

            } else {

                $parameter = [
                    'id' => $request->id,
                    'id_currency' => $request->id_currency,
                    'symbol' => $request->symbol,
                    'description' => $request->description,
                    'decimal' => $request->decimal,
                    'id_status' => $request->id_status
                ];

                $obj_Currency = new Currency();
                $result = $obj_Currency->updateCurrency($parameter);

                if ($result == Config::get('constants.STATUS_OK')) {

                    return response()->json([
                        'status' => Config::get('constants.STATUS_OK'),
                        'response' => trans('lang.saved_data')]);
                } else {

                    return response()->json([
                        'status' => Config::get('constants.STATUS_ERROR'),
                        'response' => trans('lang.insert_error')]);
                }

            }


        } catch (\Exception $e) {

            $message = trans('lang.systemError');
            $status = Config::get('constants.STATUS_ERROR');

            return response()->json([
                'status' => $status,
                'response' => $message]);
        }
    }

}
