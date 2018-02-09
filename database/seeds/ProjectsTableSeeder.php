<?php

use Illuminate\Database\Seeder;
use App\Project;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
        	'name' => 'Proceso A',
        	'description' => 'El Proceso A consiste en desarrollar un sitio web moderno.'
        ]);

        Project::create([
        	'name' => 'Proceso B',
        	'description' => 'El Proceso B consiste en desarrollar una aplicación Android.'
        ]);
    }
}
