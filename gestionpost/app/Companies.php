<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\User;
use App\ActivationCode;

class Companies extends Model
{
    protected $table = "companies";
    protected $fillable = ['id', 'business_name', 'rut', 'email', 'phone', 'address', 'latitude', 'longitude', 'id_state', 'id_city', 'id_status'];

    public function getListCompanies()
    {
        return DB::table('companies')
            ->join('statuses', 'companies.id_status', '=', 'statuses.id')
            ->join('states', 'companies.id_state', '=', 'companies.id_state')
            ->select('companies.id', 'companies.business_name', 'companies.rut', 'companies.email', 'companies.phone', 'companies.address',
                'companies.latitude', 'companies.longitude', 'companies.id_state', 'companies.id_city', 'companies.id_status', 'statuses.name',
                'states.name as name_state')
            ->paginate(20);
    }

    public function companyRegistration($parameters)
    {

        DB::beginTransaction();

        try {
            $companyTransaction = Companies::create([
                'business_name' => $parameters['business_name'],
                'rut' => $parameters['rut'],
                'email' => $parameters['email'],
                'phone' => $parameters['phone'],
                'address' => $parameters['address'],
                'latitude' => $parameters['latitude'],
                'longitude' => $parameters['longitude'],
                'id_state' => $parameters['id_state'],
                'id_city' => $parameters['id_city'],
                'id_status' => $parameters['id_status'],
            ]);
            $customerId = $companyTransaction->id;

            User::create([
                'name' => $parameters['business_name'],
                'email' => $parameters['email'],
                'password' => $parameters['password'],
                'user_type' => $parameters['user_type'],
                'customer_id' => $customerId,
            ]);

            ActivationCode::create([
                'company_id' => $customerId,
                'activation_code' => $parameters['activationCode'],
                'id_status' => $parameters['id_status']
            ]);

            DB::commit();

            return true;

        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }

    }

    public function companyData($id){
        return DB::table('companies')
                ->where('id','=', $id)
                ->get();
    }
}
