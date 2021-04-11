<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class Currency extends Model
{

    protected $table="currencies";
    protected  $fillable=['id','id_currency','symbol','description','decimal','id_status'];

    public function getCurrency(){
        return DB::table('currencies')
            ->join('statuses','currencies.id_status','=', 'statuses.id_status')
            ->select('currencies.id','currencies.id_currency','currencies.symbol',
                              'currencies.description','currencies.decimal','currencies.id_status','statuses.name')
             ->get();
    }

    public function insertCurrency($parameter){

        DB::table('currencies')
            ->insert([
               'id_currency' => $parameter['id_currency'],
               'symbol' => $parameter['symbol'],
               'description' => $parameter['description'],
               'decimal' => $parameter['decimal'],
               'id_status' => $parameter['id_status'],
               'created_at' => \Carbon\Carbon::now(),
               'updated_at' => \Carbon\Carbon::now()
            ]);
        return Config::get('constants.STATUS_OK');
    }

    public function updateCurrency($parameter){

        DB::table('currencies')
            ->where('id','=',$parameter['id'])
            ->update([
                'id_currency' => $parameter['id_currency'],
                'symbol' => $parameter['symbol'],
                'description' => $parameter['description'],
                'decimal' => $parameter['decimal'],
                'id_status' => $parameter['id_status'],
                'updated_at' => \Carbon\Carbon::now()
            ]);
        return Config::get('constants.STATUS_OK');
    }

}
