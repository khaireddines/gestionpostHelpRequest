<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;


class Neighborhood extends Model
{
    protected $table="neighborhoods";
    protected $fillable=['id','id_city','name','id_status'];

    public function getListAdmin($id_city){
        return DB::table('neighborhoods')
            ->join('statuses','neighborhoods.id_status','=','statuses.id_status')
            ->where('neighborhoods.id_city','=',$id_city)
            ->select('neighborhoods.id','neighborhoods.id_city','neighborhoods.name as name_neighborhoods','neighborhoods.id_status',
                     'statuses.name as name_state')
            ->paginate(20);
    }
}
