<?php

namespace App\Http\Controllers;

use App\Models\Cadena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CadenaController extends Controller
{

    public function validAddCadena(Request $request){
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'min' => 'El campo :attribute no debe ser menor a :min',
            'integer' => 'El campo :attribute debe ser un número',
            'string' => 'El campo :attribute debe ser de tipo texto'
        ];

        $fields = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45',
            'descripcion' => 'required|string|max:255',
            'calle' => 'required|string|max:45',
            'codigo_postal' => 'required|string|max:8|min:5',
            'colonia' => 'required|string|max:45',
            'numero' => 'required|string|max:5'
        ], $messages);

        if (!$fields->fails()) {
            $response = [
                "data" => "OK",
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

    public function getCadenasByFilter($cadena){
        $cadenas = DB::table('cadenas')
            ->join('ubicaciones', 'ubicaciones.id', '=', 'cadenas.ubicacion_id')
            ->select('ubicaciones.calle as calle', 'ubicaciones.codigo_postal as codigo_postal', 'ubicaciones.colonia as colonia', 'ubicaciones.numero as numero', 'cadenas.*')
            ->where('nombre','like','%'.$cadena.'%')
            ->orderBy('cadenas.estatus','desc')
            ->get();

        $response = [
            "data" => $cadenas
        ];
        return response($response, 200);
    }

    public function getCadenas(){
        $cadenas = DB::table('cadenas')
            ->join('ubicaciones', 'ubicaciones.id', '=', 'cadenas.ubicacion_id')
            ->select('ubicaciones.calle as calle', 'ubicaciones.codigo_postal as codigo_postal', 'ubicaciones.colonia as colonia', 'ubicaciones.numero as numero', 'cadenas.*')
            ->orderBy('cadenas.estatus','desc')
            ->get();

        $response = [
            "data" => $cadenas
        ];
        return response($response, 200);
    }

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

    public function getOnlyActive($estatus)
    {
        $store = Cadena::with('ubicacion')
        ->where('estatus',$estatus)
        ->get();
        $response = [
            "data" => $store,
            "estatus" => true
        ];
        return response($response, 200);
    }
}
