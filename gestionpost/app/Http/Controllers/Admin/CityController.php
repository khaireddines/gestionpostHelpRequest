<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\City;
use App\Status;
use App\State;

class CityController extends Controller
{
    public function listCity(Request $request)
    {
        try {

            $data_get = [
                'id' => $request->id,
            ];

            $validator = Validator::make($data_get, [
                'id' => 'required'
            ]);

            if ($validator->fails()) {

                $message = trans('lang.required_fields');
                $status = Config::get('constants.REQUIRED_FIELDS');

                return response()->json([
                    'status' => $status,
                    'response' => $message]);
            } else {
                $obj_City = new City();

                $data = $obj_City->getListAll($request->id);


                return response()->json([
                    'status' => Config::get('constants.STATUS_OK'),
                    'response' => $data]);
            }

        } catch (\Exception $e) {
            $message = trans('lang.systemError');
            $status = Config::get('constants.STATUS_ERROR');

            return response()->json([
                'status' => $status,
                'response' => $message]);
        }
    }

    public function add()
    {
        try {


            $obj_Status = new Status();
            $obj_State = new State();

            $listStatus = $obj_Status->ListStates();
            $listDepartament = $obj_State->SelectAll();

            return response()->json([
                'status' => Config::get('constants.STATUS_OK'),
                'departament' => $listDepartament,
                'listState' => $listStatus]);


        } catch (\Exception $e) {
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

            $data_get = [
                'id' => $request->id,
            ];

            $validator = Validator::make($data_get, [
                'id' => 'required'
            ]);

            if ($validator->fails()) {

                $message = trans('lang.required_fields');
                $status = Config::get('constants.REQUIRED_FIELDS');

                return response()->json([
                    'status' => $status,
                    'response' => $message]);
            } else {


                $obj_City = City::find($request->id);

                $obj_Status = new Status();
                $obj_State = new State();

                $idDepartament = $obj_City->id_state;
                $idState = $obj_City->id_status;


                $listDepartaent = $obj_State->selectOrder($idDepartament);

                $listState = $obj_Status->getListStatusOrder($idState);

                return response()->json([
                    'status' => Config::get('constants.STATUS_OK'),
                    'response' => $obj_City,
                    'departament' => $listDepartaent,
                    'listState' => $listState]);
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
                'id_state' => 'required',
                'name' => 'required',
                'id_status' => 'required'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => Config::get('constants.REQUIRED_FIELDS'),
                    'response' => trans('lang.required_fields')]);

            } else {

                $obj_City = new City();

                $obj_City->id_state = $request->id_state;
                $obj_City->name = $request->name;
                $obj_City->id_status = $request->id_status;
                $obj_City->save();

                return response()->json([
                    'status' => Config::get('constants.STATUS_OK'),
                    'response' => trans('lang.saved_data')]);

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
                'id_state' => 'required',
                'name' => 'required',
                'id_status' => 'required'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => Config::get('constants.REQUIRED_FIELDS'),
                    'response' => trans('lang.required_fields')]);

            } else {

                $obj_City = City::find($request->id);

                $obj_City->id_state = $request->id_state;
                $obj_City->name = $request->name;
                $obj_City->id_status = $request->id_status;
                $obj_City->save();

                return response()->json([
                    'status' => Config::get('constants.STATUS_OK'),
                    'response' => trans('lang.successfully_updated')]);
            }

        } catch (\Exception $e) {
            $message = trans('lang.systemError');
            $status = Config::get('constants.STATUS_ERROR');

            return response()->json([
                'status' => $status,
                'response' => $message]);
        }
    }

    public function selectOptionAllCity(Request $request)
    {
        try {

            $data_get = [
                'id_departament' => $request->id_departament,
            ];

            $validator = Validator::make($data_get, [
                'id_departament' => 'required'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => Config::get('constants.REQUIRED_FIELDS'),
                    'response' => trans('lang.required_fields')]);

            } else {

                $obj_City = new City();
                $select=$obj_City->SelectAll($request->id_departament);

                return response()->json([
                    'status' => Config::get('constants.STATUS_OK'),
                    'response' => $select]);

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
