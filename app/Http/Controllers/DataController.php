<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\userData;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    //
    public function storeUsers()
    {
        // Realizar la petición a la API
        $response = Http::get('https://jsonplaceholder.typicode.com/users');
        $users = $response->json();
        foreach ($users as $k) {
            $t = userData::where('id', $k['id'])->first();
            if (!empty($t)) continue;
            $data = [
                'nombre' => $k['name'],
                'telefono' => $k['phone'],
                'correo' => $k['email'],
                'compania' => $k['company']['name'],
                'calle' => $k['address']['street'],
                'latitud' => $k['address']['geo']['lat'],
                'longitud' => $k['address']['geo']['lng']
            ];
            userData::create($data);
        }
        return response()->json(['message' => 'Usuarios guardados correctamente']);
    }

    function show()
    {
        $users = userData::all();
        if(empty($users)) {
            $this->storeUsers();
            $users = userData::all();
        }

        return view('tabla', compact('users'));

    }

    function delete($id){
        $user = userData::find($id);
        $user->delete();
        return redirect()->route('index');
    }
    function update( Request $request)
    {

        $id = $request->id;

        if(empty($id)) {
            $user = new userData();
        }else {
            $user = userData::find($id);
        }
        $user->nombre = $request->nombre;
        $user->telefono = $request->telefono;
        $user->correo = $request->correo;
        $user->compania = $request->compania;
        $user->calle = $request->calle;
        $user->latitud = $request->latitud;
        $user->longitud = $request->longitud;
        $user->save();
        return redirect()->route('index');
    }
}
