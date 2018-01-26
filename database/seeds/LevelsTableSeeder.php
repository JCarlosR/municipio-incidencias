<?php

use Illuminate\Database\Seeder;
use App\Level;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::create([ // 1
        	'name' => 'Atención por teléfono',
        	'time' => 10,
        	'project_id' => 1
    	]);
    	Level::create([ // 2
        	'name' => 'Envío de técnico',
            'time' => 10,
        	'project_id' => 1
    	]);

    	Level::create([ // 3
        	'name' => 'Mesa de ayuda',
            'time' => 10,
        	'project_id' => 2
    	]);
    	Level::create([ // 4
        	'name' => 'Consulta especializada',
            'time' => 10,
        	'project_id' => 2
    	]);
    }
}
