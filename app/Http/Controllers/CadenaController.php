<?php

namespace App\Http\Controllers;

use App\Models\Cadena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CadenaController extends Controller
{

    public function create(Request $request)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'min' => 'El campo :attribute no debe ser menor a :min',
            'integer' => 'El campo :attribute debe ser un número',
        ];

        $fields = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45',
            'descripcion' => 'required|string|max:255',
            'estatus' => 'required|integer|min:0|max:1',
            'ubicacion_id' => 'required|integer',
        ], $messages);

        if (!$fields->fails()) {
            $store = Cadena::create([
                'nombre' => $request['nombre'],
                'descripcion' => $request['descripcion'],
                'estatus' => $request['estatus'],
                'ubicacion_id' => $request['ubicacion_id']
            ]);
            $response = [
                "data" => $store,
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

    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'min' => 'El campo :attribute no debe ser menor a :min',
            'integer' => 'El campo :attribute debe ser un número',
        ];

        $fields = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45',
            'descripcion' => 'required|string|max:255',
            'estatus' => 'required|integer|min:0|max:1',
            'ubicacion_id' => 'required|integer',
        ], $messages);

        if (!$fields->fails()) {
            $store = Cadena::find($id);
            $store->update([
                'nombre' => $request['nombre'],
                'descripcion' => $request['descripcion'],
                'estatus' => $request['estatus'],
                'ubicacion_id' => $request['ubicacion_id']
            ]);
            $response = [
                "data" => $store,
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
            "data" => Cadena::destroy($id)
        ];
        return response($response,200);
    }

    public function show()
    {
        $store = Cadena::with('ubicacion')
        ->get();
        $response = [
            "data" => $store,
            "estatus" => true
        ];
        return response($response, 200);
    }
}
