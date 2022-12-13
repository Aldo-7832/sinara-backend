<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{

    public function create()
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'string' => 'El campo :attribute debe ser de tipo texto'
        ];

        $fields = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45'
        ], $messages);

        if (!$fields->fails()) {
            $category = Categoria::create([
                'nombre' => $request['nombre']
            ]);
            $response = [
                "data" => $category,
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

    public function show(Categoria $categoria)
    {
        $category = DB::table('categorias')
        ->get();
        $response = [
            "data" => $category,
            "estatus" => true
        ];
        return response($response, 200);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'string' => 'El campo :attribute debe ser de tipo texto'
        ];

        $fields = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45'
        ], $messages);

        if (!$fields->fails()) {
            $category = Categoria::find($id);
            $category->update([
                'nombre' => $request['nombre']
            ]);
            $response = [
                "data" => $category,
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
            "data" => Categoria::destroy($id)
        ];
        return response($response,200);
    }
}
