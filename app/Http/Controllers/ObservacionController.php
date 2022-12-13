<?php

namespace App\Http\Controllers;

use App\Models\Observacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ObservacionController extends Controller
{

    public function getObservationByIdRecolectado($idRecolectado)
    {
        //
    }

    public function create(Request $request)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'integer' => 'El campo :attribute debe ser un número'
        ];

        $fields = Validator::make($request->all(), [
            'observacion' => 'required|string|max:255',
            'fecha' => 'required|date',
            'recolectado_id' => 'required|integer',
            'evidencia' => 'required'
        ], $messages);

        if (!$fields->fails()) {
            $observation = Recolectado::create([
                'observacion' => $request['observacion'],
                'fecha' => $request['fecha'],
                'recolectado_id' => $request['recolectado_id'],
                'evidencia' => $request['evidencia']
            ]);
            $response = [
                "data" => $observation,
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
        //
    }

    public function destroy($id)
    {
        //
    }
}
