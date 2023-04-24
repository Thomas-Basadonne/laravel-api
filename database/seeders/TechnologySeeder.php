<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arguments = ["laravel", "bootstrap", "vue", "nodejs", "scss", "git"];

        foreach($arguments as $argument){
            $type = new Technology();

            $type->nome = $argument;

            $type->save();
        }
    }
}