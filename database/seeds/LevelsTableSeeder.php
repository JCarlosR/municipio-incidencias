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
        	'days' => 1,
            'hours' => 10,
            'minutes' => 30,
        	'project_id' => 1
    	]);
    	Level::create([ // 2
        	'name' => 'Envío de técnico',
            'days' => 1,
            'hours' => 10,
            'minutes' => 30,
        	'project_id' => 1
    	]);
        Level::create([ // 3
            'name' => 'Visita a la central',
            'days' => 1,
            'hours' => 10,
            'minutes' => 30,
            'project_id' => 1
        ]);

    	Level::create([ // 4
        	'name' => 'Mesa de ayuda',
            'days' => 1,
            'hours' => 10,
            'minutes' => 30,
        	'project_id' => 2
    	]);
    	Level::create([ // 5
        	'name' => 'Consulta especializada',
            'days' => 1,
            'hours' => 10,
            'minutes' => 30,
        	'project_id' => 2
    	]);
    }
}
