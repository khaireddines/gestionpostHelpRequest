<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class ActivationCode extends Model
{
    protected  $table="activation_codes";
    protected  $fillable=['id','company_id','activation_code','id_status'];


    public function getActivationCode($activationCode){
        return DB::table('activation_codes')
                ->where('activation_code','=', $activationCode)
                ->get(['id','company_id','id_status']);
    }


    public function accountActivation($parameters){

        DB::beginTransaction();

        try{

            DB::table('activation_codes')
                        ->where('id','=', $parameters['id'])
                        ->update(['id_status'=>$parameters['id_status']]);

            DB::table('companies')->where('id','=', $parameters['company_id'])
                                        ->update(['id_status'=>$parameters['id_status']]);

            $userData=DB::table('users')
                        ->where('customer_id','=', $parameters['company_id'])
                        ->get(['id']);

            $idUser=$userData[0]->id;

            DB::table('users')->where('id','=',$idUser)->update(['password'=>$parameters['password']]);

            DB::commit();

            return true;

        }catch (\Exception $e){
            DB::rollback();
            return false;
        }
    }
}
