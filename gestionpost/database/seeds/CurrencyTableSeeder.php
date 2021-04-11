<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CurrencyTableSeeder extends Seeder
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
                'id_currency' => 'UYU',
                'symbol' => '$',
                'description' => 'Peso Uruguayo',
                'decimal' => 2,
                'id_status' => 1,
            ]
        ];

        DB::table('currencies') ->insert($data);

    }
}
