<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            [
                'title' => 'Homologação RCKY',
                'start' => '2022-10-01 00:00:00',
                'end' => '2022-10-02 00:00:00',
                'color' => '#ffffff',
                'description' => 'Homologação'
            ],
            [
                'title' => 'Homologação VIASOFT',
                'start' => '2022-09-01 00:00:00',
                'end' => '2022-09-02 00:00:00',
                'color' => '#ff8f00',
                'description' => 'Homologação'
            ]
        ]);
    }
}
