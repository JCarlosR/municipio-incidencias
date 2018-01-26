<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Level;

class LevelController extends Controller
{
    public function byProject($id)
    {
        return Level::where('project_id', $id)->get();
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required'
    	], [
    		'name.required' => 'Es necesario ingresar un nombre para el nivel.'
    	]);

//    	Level::create($request->all());

    	$level = new Level();
    	$level->name = $request->input('name');
        $level->days = $request->input('days');
        $level->hours = $request->input('hours');
        $level->minutes = $request->input('minutes');
        $level->project_id = $request->input('project_id');
        $level->save();

    	return back();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ], [
            'name.required' => 'Es necesario ingresar un nombre para el nivel.'
        ]);


        $level_id = $request->input('level_id');
        
        $level = Level::find($level_id);
        $level->name = $request->input('name');
        $level->days = $request->input('days');
        $level->hours = $request->input('hours');
        $level->minutes = $request->input('minutes');
        $level->save();

        return back();
    }

    public function delete($id)
    {
        Level::find($id)->delete();
        return back();
    }
}
