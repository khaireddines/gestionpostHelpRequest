<?php

namespace App\Http\Controllers\Generic;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class GenericEmailController extends Controller
{

    public function sendEmailGeneric($parameter){
        try{

            if(Config::get('constants.GENERIC_EMAIL_SHIPPING') == true){

                $dataEmail=[
                    'title' => $parameter['title'],
                    'message' => $parameter['message'],
                    'isVisible' => $parameter['isVisible'],
                    'text' => $parameter['validationCode'],
                ];

                $mailSend = $parameter['email'];
                $subject = $parameter['subject'];
                $email_template = $parameter['email_template'];

                Mail::send($email_template, $dataEmail, function ($message) use ($mailSend, $subject) {
                    $message->to($mailSend, $subject)
                        ->from('info@gestionpost.com.uy')
                        ->subject('Gestion Post');
                });

            }


        }catch (\Exception $e){
            Log::info($e);
            Log::info('error sending email');
        }
    }

}
