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
        ->orderBy('donaciones.fecha_recoleccion', 'desc')
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
            'date' => 'El campo :attribute debe ser de tipo fecha',
            'unique' => 'El folio debe ser único'
        ];

        $fields = Validator::make($request->all(), [
            'folio' => 'required|integer|min:1|unique:donaciones,folio',
            'fecha_recoleccion' => 'required|date',
            'estatus' => 'required|integer|min:0|max:1',
            'cadena_id' => 'required|integer'
        ], $messages);
        
        if (!$fields->fails()) {
            $donation = Donacion::create([
                'folio' => $request['folio'],
                'fecha_recoleccion' => $request['fecha_recoleccion'],
                'estatus' => $request['estatus'],
                'cadena_id' => $request['cadena_id'],
                'usuario_id' => $request['usuario_id'],
                'observaciones_generales' => ""
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
            'cadena_id' => 'required|integer'
        ], $messages);
        
        if (!$fields->fails()) {
            $donation = Donacion::find($id);
            $donation->update([
                'folio' => $request['folio'],
                'fecha_recoleccion' => $request['fecha_recoleccion'],
                'estatus' => $request['estatus'],
                'cadena_id' => $request['cadena_id'],
                'usuario_id' => $request['usuario_id'],
                'observaciones_generales' => ""
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

    public function show(){
        $donation = DB::table('donaciones')
        ->join('cadenas', 'cadenas.id', '=', 'donaciones.cadena_id')
        ->join('usuarios', 'usuarios.id', '=', 'donaciones.usuario_id')
        ->join('personas', 'personas.id', '=', 'usuarios.persona_id')
        ->select('personas.nombre as nombre', 'personas.primer_apellido as primer_apellido', 'personas.segundo_apellido as segundo_apellido', 'personas.telefono as telefono', 'usuarios.id as usuario_id', 'cadenas.nombre as cadena', 'cadenas.id as cadena_id', 'donaciones.*')
        ->get();
        
        $response = [
            "data" => $donation
        ];
        return response($response, 200);
    }

    public function updateStatus($id)
    {
        $donation = Donacion::find($id);
        $status = 0;
        if($donation['estatus'] == 0){
            $status = 1;
        }
        if($status == 1){
            $isDonation = DB::table('recolectados')
            ->join('donaciones', 'donaciones.id', '=', 'recolectados.donacion_id')
            ->where('recolectados.donacion_id', $id)
            ->where('recolectados.estatus', 1)
            ->count();

            if($isDonation == 0){
                $donation->update([
                    'folio' => $donation['folio'],
                    'fecha_recoleccion' => $donation['fecha_recoleccion'],
                    'estatus' => $status,
                    'cadena_id' => $donation['cadena_id'],
                    'usuario_id' => $donation['usuario_id'],
                    'observaciones_generales' => ""
                ]);
                $response = [
                    "data" => $donation,
                    "estatus" => true
                ];
                return response($response, 200);
            }else{
                $response = [
                    "data" => ['Aún tienes productos pendientes'],
                    "estatus" => false
                ];
                return response($response, 200);
            }
        }else{
            $donation->update([
                'folio' => $donation['folio'],
                'fecha_recoleccion' => $donation['fecha_recoleccion'],
                'estatus' => $status,
                'cadena_id' => $donation['cadena_id'],
                'usuario_id' => $donation['usuario_id'],
                'observaciones_generales' => ""
            ]);
            $response = [
                "data" => $donation,
                "estatus" => true
            ];
            return response($response, 200);
        }
    }

}
