<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class Status extends Model
{
    protected  $table="statuses";
    protected $fillable=['id','name','id_status'];

    public function ListStates(){
        return DB::table('statuses')
                ->whereIn('id_status', [Config::get('constants.ACTIVE'),Config::get('constants.LOCKED')])
                ->get(['id_status as id','name']);
    }

    public function getListStatusOrder($id_status){
        return DB::select('select id_status as id, name from  statuses  where id_status in(?,?) order by id_status = ? desc',[Config::get('constants.ACTIVE'),Config::get('constants.LOCKED'),$id_status]);
    }
}
