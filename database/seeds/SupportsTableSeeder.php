<?php

use Illuminate\Database\Seeder;
use App\User;

class SupportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Support - Project 1
        User::create([ // 3
        	'name' => 'Soporte S1 N1',
        	'email' => 'support1@gmail.com',
            'document' => '33333333',
        	'password' => bcrypt('123123'),
        	'role' => 1,
            'selected_project_id' => 1
        ]);
        User::create([ // 4
            'name' => 'Soporte S2 N1N2',
            'email' => 'support1B@gmail.com',
            'document' => '44444444',
            'password' => bcrypt('123123'),
            'role' => 1,
            'selected_project_id' => 1
        ]);
        User::create([ // 5
        	'name' => 'Soporte S3 N3',
        	'email' => 'support2@gmail.com',
            'document' => '55555555',
        	'password' => bcrypt('123123'),
        	'role' => 1,
            'selected_project_id' => 1
        ]);
    }
}
