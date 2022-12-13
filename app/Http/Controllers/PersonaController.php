<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PersonaController extends Controller
{

    public function create(Request $request)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'min' => 'El campo :attribute no debe ser menor a :min',
            'integer' => 'El campo :attribute debe ser un número',
            'date' => 'El campo :attribute debe ser de tipo fecha',
            'string' => 'El campo :attribute debe ser de tipo texto'
        ];

        $fields = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45',
            'primer_apellido' => 'required|string|max:45',
            'segundo_apellido' => 'string|max:45',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|string|max:10',
            'fecha_registro' => 'required|date',
            'ubicacion_id' => 'required|integer',
        ], $messages);

        if (!$fields->fails()) {
            $person = Persona::create([
                'nombre' => $request['nombre'],
                'primer_apellido' => $request['primer_apellido'],
                'segundo_apellido' => $request['segundo_apellido'],
                'fecha_nacimiento' => $request['fecha_nacimiento'],
                'telefono' => $request['telefono'],
                'fecha_registro' => $request['fecha_registro'],
                'ubicacion_id' => $request['ubicacion_id']
            ]);
            $response = [
                "data" => $person,
                "estatus" => true
            ];
            return response($response, 200);
        }else{
            $response = [
                "data" => $fields->errors(),
                "estatus" => false
            ];
            return response($response, 200);
        }
    }

    public function show()
    {
        $person = Persona::with('ubicacion')
        ->get();
        $response = [
            "data" => $person,
            "estatus" => true
        ];
        return response($response, 200);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'min' => 'El campo :attribute no debe ser menor a :min',
            'integer' => 'El campo :attribute debe ser un número',
            'date' => 'El campo :attribute debe ser de tipo fecha',
            'string' => 'El campo :attribute debe ser de tipo texto'
        ];

        $fields = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45',
            'primer_apellido' => 'required|string|max:45',
            'segundo_apellido' => 'string|max:45',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|string|max:10',
            'fecha_registro' => 'required|date',
            'ubicacion_id' => 'required|integer',
        ], $messages);

        if (!$fields->fails()) {
            $person = Persona::find($id);
            $person->update([
                'nombre' => $request['nombre'],
                'primer_apellido' => $request['primer_apellido'],
                'segundo_apellido' => $request['segundo_apellido'],
                'fecha_nacimiento' => $request['fecha_nacimiento'],
                'telefono' => $request['telefono'],
                'fecha_registro' => $request['fecha_registro'],
                'ubicacion_id' => $request['ubicacion_id']
            ]);
            $response = [
                "data" => $person,
                "estatus" => true
            ];
            return response($response, 200);
        }else{
            $response = [
                "data" => $fields->errors(),
                "estatus" => false
            ];
            return response($response, 200);
        }
    }

    public function destroy($id)
    {
        $response = [
            "data" => Persona::destroy($id)
        ];
        return response($response,200);
    }
}
