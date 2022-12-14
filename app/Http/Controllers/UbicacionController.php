<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UbicacionController extends Controller
{

    public function create(Request $request)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max caracteres',
            'min' => 'El campo :attribute no debe ser menor a :min caracteres',
            'string' => 'El campo :attribute debe ser de tipo texto'
        ];

        $fields = Validator::make($request->all(), [
            'calle' => 'required|string|max:45',
            'codigo_postal' => 'required|string|max:8|min:5',
            'colonia' => 'required|string|max:45',
            'numero' => 'required|string|max:5'
        ], $messages);

        if (!$fields->fails()) {
            $ubication = Ubicacion::create([
                'calle' => $request['calle'],
                'codigo_postal' => $request['codigo_postal'],
                'colonia' => $request['colonia'],
                'numero' => $request['numero']
            ]);
            $response = [
                "data" => $ubication,
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
        $ubication = DB::table('ubicaciones')
        ->get();
        $response = [
            "data" => $ubication,
            "estatus" => true
        ];
        return response($response, 200);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max caracteres',
            'min' => 'El campo :attribute no debe ser menor a :min caracteres',
            'string' => 'El campo :attribute debe ser de tipo texto'
        ];

        $fields = Validator::make($request->all(), [
            'calle' => 'required|string|max:45',
            'codigo_postal' => 'required|string|max:8|min:5',
            'colonia' => 'required|string|max:45',
            'numero' => 'required|string|max:5'
        ], $messages);

        if (!$fields->fails()) {
            $ubication = Ubicacion::find($id);
            $ubication->update([
                'calle' => $request['calle'],
                'codigo_postal' => $request['codigo_postal'],
                'colonia' => $request['colonia'],
                'numero' => $request['numero']
            ]);
            $response = [
                "data" => $ubication,
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
            "data" => Ubicacion::destroy($id)
        ];
        return response($response,200);
    }
}
