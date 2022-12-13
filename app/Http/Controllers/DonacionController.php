<?php

namespace App\Http\Controllers;

use App\Models\Donacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DonacionController extends Controller
{

    public function donationsByIdUser($idUser){
        $donation = Donacion::with('cadena','cadena.ubicacion')
        ->where('usuario_id', $idUser)
        ->get();
        $response = [
            "data" => $donation
        ];
        return response($response, 200);
    }

    public function create(Request $request)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'string' => 'El campo :attribute debe ser de tipo texto',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'min' => 'El campo :attribute no debe ser menor a :min',
            'integer' => 'El campo :attribute debe ser un número',
            'date' => 'El campo :attribute debe ser de tipo fecha'
        ];

        $fields = Validator::make($request->all(), [
            'folio' => 'required|integer|min:1',
            'fecha_recoleccion' => 'required|date',
            'estatus' => 'required|integer|min:0|max:1',
            'observaciones_generales' => 'string|max:255',
            'cadena_id' => 'required|integer',
            'usuario_id ' => 'required|integer'
        ], $messages);
        
        if (!$fields->fails()) {
            $donation = Donacion::create([
                'folio' => $request['folio'],
                'fecha_recoleccion' => $request['fecha_recoleccion'],
                'estatus' => $request['estatus'],
                'observaciones_generales' => $request['observaciones_generales'],
                'cadena_id' => $request['cadena_id'],
                'usuario_id' => $request['usuario_id']
            ]);
            $response = [
                "data" => $donation,
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
            'string' => 'El campo :attribute debe ser de tipo texto',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'min' => 'El campo :attribute no debe ser menor a :min',
            'integer' => 'El campo :attribute debe ser un número',
            'date' => 'El campo :attribute debe ser de tipo fecha'
        ];

        $fields = Validator::make($request->all(), [
            'folio' => 'required|integer|min:1',
            'fecha_recoleccion' => 'required|date',
            'estatus' => 'required|integer|min:0|max:1',
            'observaciones_generales' => 'string|max:255',
            'cadena_id' => 'required|integer',
            'usuario_id ' => 'required|integer'
        ], $messages);
        
        if (!$fields->fails()) {
            $donation = Donacion::find($id);
            $donation->update([
                'folio' => $request['folio'],
                'fecha_recoleccion' => $request['fecha_recoleccion'],
                'estatus' => $request['estatus'],
                'observaciones_generales' => $request['observaciones_generales'],
                'cadena_id' => $request['cadena_id'],
                'usuario_id' => $request['usuario_id']
            ]);
            $response = [
                "data" => $donation,
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
            "data" => Donacion::destroy($id)
        ];
        return response($response,200);
    }
}
