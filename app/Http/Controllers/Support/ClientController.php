<?php

namespace App\Http\Controllers\Support;

use App\IncidentChange;
use App\Rules\ValidDocument;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index (Request $request)
    {
        $searchClient = $request->input('search_client');

        $query = User::where('role', 2);

        if ($searchClient) { // search clients
            $query = $query->where(function ($query) use ($searchClient) {
                $query->where('name', 'like', "%$searchClient%")
                    ->orWhere('document', 'like', "%$searchClient%");
            });
        }

        $clients = $query->paginate(6);

        return view('support.clients.index')->with(compact('clients', 'searchClient'));
    }
    public function create()
    {

        return view('support.clients.create');
    }

    public function store(Request $request)
    {
        $document = $request->input('document');

        $rules = [
            'name' => 'required|max:255',
            'email' => 'email|max:255',
            'document' => ['required','max:255','unique:users', 'valid_document'],
            'password' => 'required|min:6'
        ];
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre del usuario.',
            'name.max' => 'El nombre es demasiado extenso.',
            'email.email' => 'El e-mail ingresado no es válido.',
            'email.max' => 'El e-mail es demasiado extenso.',
            'document.required' => 'Es indispensable ingresar la cédula del usuario.',
            'document.max' => 'La cédula es demasiado extenso.',
            'document.unique' => 'Este cédula ya se encuentra en uso.',
            'document.valid_document' => 'La cédula ingresada no es válida.',
            'password.required' => 'Olvidó ingresar una contraseña.',
            'password.min' => 'La contraseña debe presentar al menos 6 caracteres.'
        ];
        $this->validate($request, $rules, $messages);

        $client = new User();
        $client->name = $request->input('name');
        $client->cellphone = $request->input('cellphone');
        $client->email = $request->input('email');
        $client->address = $request->input('address');
        $client->document = $document;
        $client->password = bcrypt($request->input('password'));
        $client->role = 2;
        $client->save();

        return redirect('/cliente')->with('notification', 'Cliente registrado exitosamente.');
    }

    public function edit($id)
    {
        $client = User::find($id);

        return view('support.clients.edit')->with(compact('client'));
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'email|max:255',
            'password' => 'min:6'
        ];
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre del usuario.',
            'name.max' => 'El nombre es demasiado extenso.',
            'email.email' => 'El e-mail ingresado no es válido.',
            'email.max' => 'El e-mail es demasiado extenso.',
            'password.required' => 'Olvidó ingresar una contraseña.',
            'password.min' => 'La contraseña debe presentar al menos 6 caracteres.'
        ];
        $this->validate($request, $rules, $messages);

        $client = User::find($id);
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->cellphone = $request->input('cellphone');
        $client->address = $request->input('address');
        $password = $request->input('password');
        if ($password)
            $client->password = bcrypt($password);

        $client->save();

        return back()->with('notification', 'Cliente modificado exitosamente.');
    }

    public function delete($id)
    {
        $client = User::find($id);
        $client->delete();

        return back()->with('notification', 'El cliente se ha dado de baja correctamente.');
    }

}
