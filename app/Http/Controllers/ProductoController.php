<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{

    public function create(Request $request)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'integer' => 'El campo :attribute debe ser un número',
            'string' => 'El campo :attribute debe ser de tipo texto'
        ];

        $fields = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45',
            'descripcion' => 'required|string|255',
            'categoria_id' => 'required|integer'
        ], $messages);

        if (!$fields->fails()) {
            $product = Producto::create([
                'nombre' => $request['nombre'],
                'descripcion' => $request['descripcion'],
                'categoria_id' => $request['categoria_id']
            ]);
            $response = [
                "data" => $product,
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
        $product = Producto::with('categoria')
        ->get();
        $response = [
            "data" => $product,
            "estatus" => true
        ];
        return response($response, 200);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'integer' => 'El campo :attribute debe ser un número',
            'string' => 'El campo :attribute debe ser de tipo texto'
        ];

        $fields = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45',
            'descripcion' => 'required|string|255',
            'categoria_id' => 'required|integer'
        ], $messages);

        if (!$fields->fails()) {
            $product = Producto::find($id);
            $product->update([
                'nombre' => $request['nombre'],
                'descripcion' => $request['descripcion'],
                'categoria_id' => $request['categoria_id']
            ]);
            $response = [
                "data" => $product,
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
            "data" => Producto::destroy($id)
        ];
        return response($response,200);
    }
}
