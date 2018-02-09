<?php

use App\IncidentChange;
use Illuminate\Database\Seeder;
use App\Incident;

class IncidentsTableSeeder extends Seeder
{

    public function run()
    {

        $incident = Incident::create([
        	'title' => 'Primera incidencia',
        	'description' => 'Lo que ocurre es que se encontró un problema en la página y esta se cerró.',
        	'severity' => 'N',
        	'category_id' => 2,
        	'project_id' => 1,
        	'level_id' => 1,
        	'client_id' => 2,
            'creator_id' => 3
    	]);
        IncidentChange::create([
            'type' => 'registry',
            'incident_id' => $incident->id,
            'user_id' => 3
        ]);
    }
}
