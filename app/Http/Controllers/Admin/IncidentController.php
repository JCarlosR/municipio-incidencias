<?php

namespace App\Http\Controllers\Admin;

use App\Incident;
use App\IncidentChange;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IncidentController extends Controller
{
    public function index(Request $request)
    {
        $searchIncident = $request->input('document');
        $searchState = $request->input('state');

        $query = Incident::query();

        if ($searchState) {
            if ($searchState == 'Resuelto')
                $query = $query->where('active', 0);
            elseif ($searchState == 'Asignado')
                $query = $query->where('active', 1)
                    ->whereNotNull('support_id');
            else
                $query = $query = $query->where('active', 1)
                ->whereNull('support_id');
        }
        if ($searchIncident) { // search by document
            $userIds = User::where('document', 'like', "%$searchIncident%")->pluck('id');
            $query = $query->whereIn('client_id', $userIds);
        }

        $incidents = $query->paginate(5);

        // always paginate
        return view('admin.incidents.index')
            ->with(compact('incidents', 'searchIncident', 'searchState'));
    }

    public function show($id)
    {
        $incident = Incident::findOrFail($id);
        $incident_histories = IncidentChange::where('incident_id', $id)->get();

        return view('admin.incidents.show')->with(compact('incident', 'incident_histories'));
    }
}
