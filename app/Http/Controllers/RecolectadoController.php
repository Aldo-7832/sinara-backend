<?php

namespace App\Http\Controllers;

use App\Models\Recolectado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RecolectadoController extends Controller
{

    public function getProductsByIdDonation($idDonation, $idUser){
        $products = DB::table('recolectados')
            ->join('productos', 'productos.id', '=', 'recolectados.producto_id')
            ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
            ->join('donaciones', 'recolectados.donacion_id', '=', 'donaciones.id')
            ->select('recolectados.*', 'productos.nombre as producto', 'categorias.nombre as categoria')
            ->where('donacion_id', $idDonation)
            ->where('donaciones.usuario_id', $idUser)
            ->get();

        $response = [
            "data" => $products
        ];
        return response($response, 200);
    }

    public function getFilterProductsByIdDonation($idDonation, $idUser, $product){
        $products = DB::table('recolectados')
            ->join('productos', 'productos.id', '=', 'recolectados.producto_id')
            ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
            ->join('donaciones', 'recolectados.donacion_id', '=', 'donaciones.id')
            ->select('recolectados.*', 'productos.nombre as producto', 'categorias.nombre as categoria')
            ->where('donacion_id', $idDonation)
            ->where('donaciones.usuario_id', $idUser)
            ->where('productos.nombre','like','%'.$product.'%')
            ->get();

        $response = [
            "data" => $products
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
            'date' => 'El campo :attribute debe ser de tipo fecha'
        ];

        $fields = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1',
            'caducidad' => 'required|date',
            'estatus' => 'required|integer|min:0|max:1',
            'producto_id' => 'required|integer',
            'donacion_id' => 'required|integer'
        ], $messages);
        
        if (!$fields->fails()) {
            $picking = Recolectado::find($id);
            $picking->update([
                'cantidad' => $request['cantidad'],
                'caducidad' => $request['caducidad'],
                'estatus' => $request['estatus'],
                'producto_id' => $request['producto_id'],
                'donacion_id' => $request['donacion_id']
            ]);
            $response = [
                "data" => $picking,
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

    public function updateStatus($id)
    {
        $picking = Recolectado::find($id);
        $status = 0;
        if($picking['estatus'] == 0){
            $status = 1;
        }
        $picking->update([
            'cantidad' => $picking['cantidad'],
            'caducidad' => $picking['caducidad'],
            'estatus' => $status,
            'producto_id' => $picking['producto_id'],
            'donacion_id' => $picking['donacion_id']
        ]);
        $response = [
            "data" => $picking,
            "estatus" => true
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
            'date' => 'El campo :attribute debe ser de tipo fecha'
        ];

        $fields = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1',
            'caducidad' => 'required|date',
            'estatus' => 'required|integer|min:0|max:1',
            'producto_id' => 'required|integer',
            'donacion_id' => 'required|integer'
        ], $messages);
        
        if (!$fields->fails()) {
            $picking = Recolectado::create([
                'cantidad' => $request['cantidad'],
                'caducidad' => $request['caducidad'],
                'estatus' => $request['estatus'],
                'producto_id' => $request['producto_id'],
                'donacion_id' => $request['donacion_id']
            ]);
            $response = [
                "data" => $picking,
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
            "data" => Recolectado::destroy($id)
        ];
        return response($response,200);
    }
}
