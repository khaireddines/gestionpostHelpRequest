<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use App\Companies;
use App\User;
use App\Http\Controllers\Generic\GenericEmailController;
use App\ActivationCode;

class CompanyController extends Controller
{





    public function accountActivation(Request $request){

        try{

            $validator = Validator::make($request->all(), [
                'activation_code' => 'required',
                'password' => 'required',
                'repeat_password' => 'required'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => Config::get('constants.REQUIRED_FIELDS'),
                    'response' => trans('lang.required_fields')]);
            }else{

                $obj_ActivationCode= new ActivationCode();
                $obj_Companies= new Companies();
                $obj_GenericEmailController = new GenericEmailController();

                $data=$obj_ActivationCode->getActivationCode($request->activation_code);

                $countData=count($data);

                if($countData > 0){

                    $id=$data[0]->id;
                    $company_id=$data[0]->company_id;
                    $id_status=$data[0]->id_status;

                    if($id_status == Config::get('constants.LOCKED')){

                        if(md5($request->password) == md5($request->repeat_password)){

                            $parameters=[
                                'id' => $id,
                                'company_id' => $company_id,
                                'password' => Hash::make($request->password),
                                'id_status' => Config::get('constants.ACTIVE'),
                            ];

                            $result=$obj_ActivationCode->accountActivation($parameters);


                            if($result == true){

                                $data=$obj_Companies->companyData($company_id);
                                $email=$data[0]->email;

                                $parameters = [
                                    'title' => trans('lang.email_account_activation'),
                                    'message' => trans('lang.activation_message'),
                                    'email' => $email,
                                    'subject' => trans('lang.company_registration'),
                                    'email_template' => 'emails.emailGeneric',
                                    'isVisible' => false,
                                    'text' => ''
                                ];

                                $obj_GenericEmailController->sendEmailGeneric($parameters);

                                return response()->json([
                                    'status' => Config::get('constants.STATUS_OK'),
                                    'response' => trans('lang.activation_message')]);
                            }else{

                                $message = trans('lang.systemError');
                                $status = Config::get('constants.STATUS_ERROR');

                                return response()->json([
                                    'status' => $status,
                                    'response' => $message]);
                            }

                        }else{

                            $message = trans('lang.wrong_passwords');
                            $status = Config::get('constants.STATUS_ERROR');

                            return response()->json([
                                'status' => $status,
                                'response' => $message]);
                        }

                    }else{

                        $message = trans('lang.account_activated');
                        $status = Config::get('constants.STATUS_ERROR');

                        return response()->json([
                            'status' => $status,
                            'response' => $message]);
                    }

                }else{

                    $message = trans('lang.systemError');
                    $status = Config::get('constants.STATUS_ERROR');

                    return response()->json([
                        'status' => $status,
                        'response' => $message]);
                }
            }

        }catch (\Exception $e){
            $message = trans('lang.systemError');
            $status = Config::get('constants.STATUS_ERROR');

            return response()->json([
                'status' => $status,
                'response' => $message]);
        }

    }

}
