<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use App\Companies;
use App\Http\Controllers\Generic\GenericEmailController;
use App\State;

class BusinessController extends Controller
{

    use ApiResponse;

    protected $companies;
    protected $state;
    protected $genericEmail;

    public function __construct()
    {

        $this->companies = new Companies();
        $this->state = new State();
        $this->genericEmail=new GenericEmailController();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {

            $data=$this->companies->getListCompanies();
            return $this->showAll($data);

        } catch (\Exception $e) {
            return $this->exceptionError();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        try {

            $data = $this->state->SelectAll();
            return $this->showAll($data);

        } catch (\Exception $e) {
            return $this->exceptionError();
        }
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
                'business_name' => 'required',
                'rut' => [
                    'required',
                    'unique:companies'
                ],
                'email' => [
                    'required',
                    'unique:companies'
                ],
                'phone' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'id_state' => 'required',
                'id_city' => 'required',
            ]);


            if ($validator->fails()) {
                return $this->errorResponse(trans('lang.required_fields'),Config::get('constants.REQUIRED_FIELDS') );
            }else{


                $password=$this->generateRegistrationPassword(10);
                $activationCode = $this->generateCode();


                $parameters=[
                    'business_name' => $request->business_name,
                    'rut' => $request->rut,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'id_state' => $request->id_state,
                    'id_city' => $request->id_city,
                    'id_status' => Config::get('constants.LOCKED'),
                    'user_type' => Config::get('constants.BUSINESS_USER'),
                    'password' =>Hash::make($password),
                    'activationCode' => $activationCode
                ];


                $result=$this->companies->companyRegistration($parameters);

                if($result == true){

                    $parameters = [
                        'title' => trans('lang.company_registration'),
                        'message' => trans('lang.company_registration_message'),
                        'email' => $request->email,
                        'subject' => trans('lang.company_registration'),
                        'email_template' => 'emails.emailGeneric',
                        'isVisible' => true,
                        'validationCode' => $activationCode
                    ];

                    $this->genericEmail->sendEmailGeneric($parameters);

                    return $this->showMessage(trans('lang.account_activation'));


                }else{
                    return $this->errorResponse(trans('lang.company_registration_error'),Config::get('constants.STATUS_ERROR'));
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
