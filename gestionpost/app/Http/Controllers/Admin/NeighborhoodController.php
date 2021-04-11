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
use App\Neighborhood;


class NeighborhoodController extends Controller
{
    public function listNeighborhood(Request $request)
    {
        try {

            $data_get = [
                'id_city' => $request->id_city,
            ];

            $validator = Validator::make($data_get, [
                'id_city' => 'required'
            ]);

            if ($validator->fails()) {

                $message = trans('lang.required_fields');
                $status = Config::get('constants.REQUIRED_FIELDS');

                return response()->json([
                    'status' => $status,
                    'response' => $message]);
            } else {

                $obj_neighborhood = new Neighborhood();

                $list = $obj_neighborhood->getListAdmin($request->id_city);

                return response()->json([
                    'status' => Config::get('constants.STATUS_OK'),
                    'response' => $list]);
            }

        } catch (\Exception $e) {
            $message = trans('lang.systemError');
            $status = Config::get('constants.STATUS_ERROR');

            return response()->json([
                'status' => $status,
                'response' => $message]);
        }
    }


    public function add(){
        try{

            $obj_State= new State();
            $obj_Status= new Status();

            $list_departament=$obj_State->SelectAll();
            $list_state=$obj_Status->ListStates();

            return response()->json([
                'status' => Config::get('constants.STATUS_OK'),
                'departament' => $list_departament,
                'state' => $list_state]);


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

                $obj_neighborhood = Neighborhood::find($request->id);


                $id_city = $obj_neighborhood->id_city;
                $id_status=$obj_neighborhood->id_status;


                $obj_city = City::find($id_city);



                $id_depertament = $obj_city->id_state;

                $obj_departament = new State();
                $objCity= new City();
                $obj_status= new Status();


                $department = $obj_departament->selectOrder($id_depertament);
                $city_select = $objCity->selectOrder($id_city, $id_depertament);
                $list_status=$obj_status->getListStatusOrder($id_status);

                return response()->json([
                    'status' => Config::get('constants.STATUS_OK'),
                    'departament' => $department,
                    'city' => $city_select,
                    'response' => $obj_neighborhood,
                    'id_depertament' => $id_depertament,
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
                'id_city' => 'required',
                'name' => 'required',
                'id_status' => 'required'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => Config::get('constants.REQUIRED_FIELDS'),
                    'response' => trans('lang.required_fields')]);

            } else {

                $obj_Neighborhood = new Neighborhood();

                $obj_Neighborhood->id_city = $request->id_city;
                $obj_Neighborhood->name = $request->name;
                $obj_Neighborhood->id_status = $request->id_status;
                $obj_Neighborhood->save();

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
                'id_city' => 'required',
                'name' => 'required',
                'id_status' => 'required'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => Config::get('constants.REQUIRED_FIELDS'),
                    'response' => trans('lang.required_fields')]);

            } else {

                $obj_Neighborhood = Neighborhood::find($request->id);

                $obj_Neighborhood->id_city = $request->id_city;
                $obj_Neighborhood->name = $request->name;
                $obj_Neighborhood->id_status = $request->id_status;
                $obj_Neighborhood->save();

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
}
