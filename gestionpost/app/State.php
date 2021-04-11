<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class State extends Model
{
    protected $table="states";
    protected  $fillable=['id','name','id_status'];

    public function getListAll(){
        return DB::table('states')
            ->join('statuses','states.id_status','=','statuses.id_status')
           ->whereIn('states.id_status',[Config::get('constants.ACTIVE'),Config::get('constants.LOCKED')])
           ->select('states.id','states.name','states.id_status','statuses.name as name_status')
            ->get();
    }

    public function insertStates($parameter){
        DB::table('states')
                ->insert([
                    'name' => $parameter['name'],
                    'id_status' => $parameter['id_status'],
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]);
        return Config::get('constants.STATUS_OK');
    }

    public function updateStates($parameter){

        return DB::table('states')
            ->where('id','=', $parameter['id'])
            ->update([
                'name' => $parameter['name'],
                'id_status' => $parameter['id_status'],
                'updated_at' => \Carbon\Carbon::now()
            ]);
    }

    public function deleteSates($id){

        return DB::table('states')->where('id','=',$id)->delete();
    }

    public function SelectAll(){
        return DB::table('states')
            ->where('states.id_status','=', Config::get('constants.ACTIVE'))
            ->get(['states.id','states.name']);
    }

    public function selectOrder($id){
        return DB::select('select  id, name from  states  where id_status in(?) order by id = ? desc',[Config::get('constants.ACTIVE'),$id]);
    }
}
