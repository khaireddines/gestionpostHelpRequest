<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use App\Companies;
use App\User;
use App\Http\Controllers\Generic\GenericEmailController;
use App\ActivationCode;


class BusinessAccountController extends Controller
{

    use ApiResponse;

    protected $activationCode;
    protected $companies;
    protected $emailGeneric;

    public function __construct()
    {

        $this->activationCode = new ActivationCode();
        $this->companies = new Companies();
        $this->emailGeneric = new GenericEmailController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'activation_code' => 'required',
                'password' => 'required',
                'repeat_password' => 'required'
            ]);

            if ($validator->fails()) {

                return $this->errorResponse(trans('lang.required_fields'), Config::get('constants.REQUIRED_FIELDS'));
            } else {

                $data = $this->activationCode->getActivationCode($request->activation_code);
                $countData = count($data);


                if ($countData > 0) {

                    $id = $data[0]->id;
                    $company_id = $data[0]->company_id;
                    $id_status = $data[0]->id_status;

                    if ($id_status == Config::get('constants.LOCKED')) {

                        $parameters = [
                            'id' => $id,
                            'company_id' => $company_id,
                            'password' => Hash::make($request->password),
                            'id_status' => Config::get('constants.ACTIVE'),
                        ];

                        $result = $this->activationCode->accountActivation($parameters);

                        if ($result == true) {

                            $data = $this->companies->companyData($company_id);
                            $email = $data[0]->email;

                            $parameters = [
                                'title' => trans('lang.email_account_activation'),
                                'message' => trans('lang.activation_message'),
                                'email' => $email,
                                'subject' => trans('lang.company_registration'),
                                'email_template' => 'emails.emailGeneric',
                                'isVisible' => false,
                                'text' => ''
                            ];

                            $this->emailGeneric->sendEmailGeneric($parameters);

                            return $this->showMessage(trans('lang.activation_message'), Config::get('constants.STATUS_OK'));
                        }

                    } else {

                        return $this->errorResponse(trans('lang.account_activated'), Config::get('constants.STATUS_ERROR'));
                    }

                } else {

                    $this->errorResponse(trans('lang.systemError'), Config::get('constants.STATUS_ERROR'));
                }

            }

        } catch (\Exception $e) {
            return $this->exceptionError();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
