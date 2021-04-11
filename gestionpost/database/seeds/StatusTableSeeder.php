<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Activo',
                'id_status' => 1,
            ],
            [
                'name' => 'Bloqueado',
                'id_status' => 2,
            ],
            [
                'name' => 'Entregado',
                'id_status' => 3,
            ],
            [
                'name' => 'En Curso',
                'id_status' => 4,
            ],
            [
                'name' => 'No Entregado',
                'id_status' => 4,
            ],
            [
                'name' => 'No Retirado',
                'id_status' => 6,
            ],


        ];

        DB::table('statuses') ->insert($data);
    }
}
