<?php

namespace App\Http\Controllers\Support;

use App\IncidentChange;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function create()
    {
        $clients = User::where('role', 2)->get();
        return view('support.clients.create')->with(compact('clients'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'email|max:255',
            'document' => 'required|max:255|unique:users',
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
            'password.required' => 'Olvidó ingresar una contraseña.',
            'password.min' => 'La contraseña debe presentar al menos 6 caracteres.'
        ];
        $this->validate($request, $rules, $messages);

        $client = new User();
        $client->name = $request->input('name');
        $client->cellphone = $request->input('cellphone');
        $client->email = $request->input('email');
        $client->address = $request->input('address');
        $client->document = $request->input('document');
        $client->password = bcrypt($request->input('password'));
        $client->role = 2;
        $client->save();

        return back()->with('notification', 'Cliente registrado exitosamente.');
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
            'document' => 'required|max:255|unique:users',
            'password' => 'min:6'
        ];
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre del usuario.',
            'name.max' => 'El nombre es demasiado extenso.',
            'email.email' => 'El e-mail ingresado no es válido.',
            'email.max' => 'El e-mail es demasiado extenso.',
            'document.required' => 'Es indispensable ingresar la cédula del usuario.',
            'document.max' => 'La cédula es demasiado extenso.',
            'document.unique' => 'Este cédula ya se encuentra en uso.',
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
