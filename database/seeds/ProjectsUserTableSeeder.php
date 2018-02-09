<?php

use Illuminate\Database\Seeder;
use App\ProjectUser;

class ProjectsUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user 3
        ProjectUser::create([
        	'project_id' => 1,
        	'user_id' => 3,
        	'level_id' => 1
		]);

        // user 4
        ProjectUser::create([
            'project_id' => 1,
            'user_id' => 4,
            'level_id' => 1
        ]);
		ProjectUser::create([
        	'project_id' => 1,
        	'user_id' => 4,
        	'level_id' => 2
		]);

		// user 5
        ProjectUser::create([
            'project_id' => 1,
            'user_id' => 5,
            'level_id' => 3
        ]);
    }
}
