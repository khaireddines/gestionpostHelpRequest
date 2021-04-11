<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\State;
use App\Status;


class StateController extends Controller
{
    public function ListStates()
    {
        try {

            $obj_State = new State();
            $data = $obj_State->getListAll();

            return response()->json([
                'status' => Config::get('constants.STATUS_OK'),
                'response' => $data]);

        } catch (\Exception $e) {
            $message = trans('lang.systemError' . $e);
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
                'id' => $request->id,
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

                $obj_State = State::find($request->id);
                $obj_Status = new Status();

                $id_status = $obj_State->id_status;
                $list_status = $obj_Status->getListStatusOrder($id_status);

                return response()->json([
                    'status' => Config::get('constants.STATUS_OK'),
                    'response' => $obj_State,
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
                'name' => 'required',
                'id_status' => 'required'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => Config::get('constants.REQUIRED_FIELDS'),
                    'response' => trans('lang.required_fields')]);

            } else {

                $obj_State = new State();

                $parameter = [
                    'name' => $request->name,
                    'id_status' => $request->id_status
                ];

                $result = $obj_State->insertStates($parameter);

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
                'name' => 'required',
                'id_status' => 'required'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => Config::get('constants.REQUIRED_FIELDS'),
                    'response' => trans('lang.required_fields')]);

            } else {

                $obj_State = new State();

                $parameter = [
                    'id' => $request->id,
                    'name' => $request->name,
                    'id_status' => $request->id_status
                ];

                $result = $obj_State->updateStates($parameter);

                if ($result == Config::get('constants.RESPONSE_UPDATE')) {

                    return response()->json([
                        'status' => Config::get('constants.STATUS_OK'),
                        'response' => trans('lang.successfully_updated')]);

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

    public function delete(Request $request)
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

                $obj_states= new State();
                $result=$obj_states->deleteSates($request->id);

                if($result == Config::get('constants.RESPONSE_DELETE')){

                    return response()->json([
                        'status' => Config::get('constants.STATUS_OK'),
                        'response' => trans('lang.successfully_deleted')]);

                }else{

                    return response()->json([
                        'status' => Config::get('constants.STATUS_ERROR'),
                        'response' => trans('lang.error_deleting_date')]);
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

    public function selectDepartament(){
        try{

            $obj_State = new State();
            $data = $obj_State->SelectAll();

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
}
