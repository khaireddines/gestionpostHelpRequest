<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class City extends Model
{
    protected $table="cities";
    protected $fillable=['id','id_state','name','id_status'];

    public function getListAll($id_state){
        return DB::table('cities')
                ->join('states','cities.id_state','=', 'states.id')
                ->join('statuses','cities.id_status','=','statuses.id_status')
                ->where('cities.id_state','=',$id_state)
                ->select('cities.id','cities.id_state','cities.name','cities.id_status','states.name as state_name','statuses.name as name_status')
                ->get();

    }

    public function SelectAll($id_state){
        return DB::table('cities')
            ->where('id_status','=', Config::get('constants.ACTIVE'))
            ->where('cities.id_state','=',$id_state)
            ->get(['id','name']);
    }

    public function selectOrder($id,$id_state){
        return DB::select('select  id, name from  cities  where id_state=? and  id_status in(?) order by id = ? desc',[$id_state,Config::get('constants.ACTIVE'),$id]);
    }
}
