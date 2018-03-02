<?php

namespace App\Http\Controllers;

use App\IncidentChange;
use App\Level;
use App\User;
use Illuminate\Http\Request;
use App\Category;
use App\Incident;
use App\Project;
use App\ProjectUser;

class IncidentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $incident = Incident::findOrFail($id);
        $incident_histories = IncidentChange::where('incident_id', $id)->get();

        $user = auth()->user();
        $project_id = $user->selected_project_id;
        $first = Level::where('project_id', $project_id)->get()->first();
        $last = Level::where('project_id', $project_id)->get()->last();

        $take_incident = Incident::where('id', $id)->where('support_id', $user->id)
                    ->where('project_id', $project_id)->whereIn('level_id', [$first->id, $last->id])->exists();
        $messages = $incident->messages;
        return view('incidents.show')->with(compact('incident', 'messages', 'incident_histories', 'take_incident', 'first'));
    }

    public function create() 
    {
        $categories = Category::where('project_id', auth()->user()->selected_project_id)->get();
        $clients = User::where('role', 2)->get();
        return view('incidents.create')->with(compact('categories','clients'));
    }

    public function store(Request $request)
    {
        $this->validate($request, Incident::$rules, Incident::$messages);
        $document = $request->input('document');

        $client = User::where('document', $document)->first();

        $incident = new Incident();
        $incident->category_id = $request->input('category_id') ?: null;
        $incident->severity = $request->input('severity');
        $incident->description = $request->input('description');

        $user = auth()->user();

        $incident->creator_id = $user->id;
        $incident->client_id = $client->id;
        $incident->project_id = $user->selected_project_id;
        $incident->level_id = Project::find($user->selected_project_id)->first_level_id;

        $incident->save();

        $history = new IncidentChange();
        $history->type = 'registry';
        $history->incident_id = $incident->id;
        $history->user_id = $user->id;
        $history->save();

        return redirect("/vista/$incident->id")->with('notification', 'Incidencia registrada correctamente.');

    }

    public function preview($id)
    {
        $count_days = $count_hours = $count_minutes = 0;
        $incident = Incident::findOrFail($id);

        $incident_count = Incident::where('project_id', $incident->project_id)
                            ->where('id', '<', $incident->id)->where('active', 1)->count() +1;

        $project = $incident->project;
        foreach($project->levels as $level){
            $count_days = $count_days + $level->days;
            $count_hours = $count_hours + $level->hours;
            $count_minutes = $count_minutes + $level->minutes;
            if ($count_minutes >= 60){
                $count_minutes = $count_minutes - 60;
                $count_hours = $count_hours + 1;
            }
            if ($count_hours >= 24){
                $count_hours = $count_hours - 24;
                $count_days = $count_days + 1;
            }
        }

        return view ('incidents.preview')->with(compact('incident', 'count_days', 'count_hours', 'count_minutes', 'incident_count'));
    }

    public function edit($id)
    {
        $incident = Incident::findOrFail($id);
        $user = auth()->user();
        $project_id = $user->selected_project_id;
        $first = Level::where('project_id', $project_id)->get()->first();
        $categories = $incident->project->categories;
        $clients = User::where('role', 2)->get();
        return view('incidents.edit')->with(compact('incident', 'categories','clients','first'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, Incident::$rules, Incident::$messages);

        $incident = Incident::findOrFail($id);
        $user = auth()->user();
        $project_id = $user->selected_project_id;
        $first = Level::where('project_id', $project_id)->get()->first();

        if ($user->id == $incident->creator_id && $incident->level_id == $first->id && $incident->support_id == NULL) {

            $incident->category_id = $request->input('category_id') ?: null;
            $incident->severity = $request->input('severity');
            $incident->description = $request->input('description');

            $incident->save();

            $user_id = auth()->id();
            $history = new IncidentChange();
            $history->type = 'edit';
            $history->incident_id = $incident->id;
            $history->user_id = $user_id;
            $history->save();

            return redirect("/ver/$id");
        }else{
            return redirect("/incidencia/$incident->id/editar");
        }
    }

    public function take($id)
    {
        $user = auth()->user();

        if (! $user->is_support)
            return back();

        $incident = Incident::findOrFail($id);

        // There is a relationship between user and project?
        // Is assigned to this level?
        $assigned = ProjectUser::where('project_id', $incident->project_id)
            ->where('user_id', $user->id)->where('level_id', $incident->level_id)->exists();

        if (!$assigned)
            return back();

        $incident->support_id = $user->id;
        $incident->save();

        $history = new IncidentChange();
        $history->type = 'attention';
        $history->incident_id = $incident->id;
        $history->user_id = $incident->support_id;
        $history->save();

        return back();
    }

    public function solve($id)
    {
        $incident = Incident::findOrFail($id);
        $user_id = auth()->id();
        // Is the user authenticated the author of the incident?
        if ($incident->support_id != $user_id)
            return back();
           
        $incident->active = 0; // false
        $incident->save();

        $history = new IncidentChange();
        $history->type = 'resolved';
        $history->incident_id = $incident->id;
        $history->user_id = $user_id;
        $history->save();

        return back();
    }

    public function open($id)
    {
        $incident = Incident::findOrFail($id);

        // Is the user authenticated the author of the incident?
        if ($incident->support_id != auth()->user()->id)
            return back();
           
        $incident->active = 1; // true
        $incident->save();

        $history = new IncidentChange();
        $history->type = 'open';
        $history->incident_id = $incident->id;
        $history->user_id = auth()->id();
        $history->save();

        return back();
    }

    public function nextLevel($id)
    {
        $incident = Incident::findOrFail($id);
        $level_id = $incident->level_id;

        $project = $incident->project;
        $levels = $project->levels;

        $next_level_id = $this->getNextLevelId($level_id, $levels);

        if ($next_level_id) {
            $incident->level_id = $next_level_id;
            $incident->support_id = null;
            $incident->save();

            $history = new IncidentChange();
            $history->type = 'derive';
            $history->incident_id = $incident->id;
            $history->user_id = auth()->id();
            $history->save();

            return back();
        }

        return back()->with('notification', 'No es posible derivar porque no hay un siguiente nivel.');
    }

    public function getNextLevelId($level_id, $levels)
    {
        if (sizeof($levels) <= 1)
            return null;

        $position = -1;
        for ($i=0; $i<sizeof($levels)-1; $i++) { // -1
            if ($levels[$i]->id == $level_id) {
                $position = $i;
                break;
            }
        }

        if ($position == -1)
            return null;

        // if ($position == sizeof($levels)-1)
        //     return null;

        return $levels[$position+1]->id;
    }

}
