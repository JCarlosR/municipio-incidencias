<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ProjectUser;

class ProjectUserController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'project_id' => 'exists:projects,id',
            'user_id' => 'exists:users,id',
            'level_id' => 'exists:levels,id'
        ];
        $this->validate($request, $rules);
        // Seguridad adicional:
    	// Verificar que el nivel pertenezca al proyecto.

    	$projectId = $request->input('project_id');
    	$userId = $request->input('user_id');
        $levelId = $request->input('level_id');

		$projectLevelUser = ProjectUser::where('project_id', $projectId)
            ->where('user_id', $userId)->where('level_id', $levelId)->first();

		if ($projectLevelUser)
			return back()->with('notification', 'El usuario ya pertenece a este nivel del proceso.');

    	$project_user = new ProjectUser();
    	$project_user->project_id = $projectId;
    	$project_user->user_id = $userId;
    	$project_user->level_id = $levelId;
    	$project_user->save();

    	return back();
    }

    public function delete($id)
    {
    	ProjectUser::find($id)->delete();
    	return back();
    }
}
