<?php

namespace App\Http\Controllers;

use App\Models\Recolectado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class RecolectadoController extends Controller
{
    
    public function donationsByCollectedDate($fecha_inicial, $fecha_final){
        $products = DB::table('recolectados')
        ->join('productos', 'productos.id', '=', 'recolectados.producto_id')
        ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
        ->join('donaciones', 'recolectados.donacion_id', '=', 'donaciones.id')
        ->join('usuarios','usuarios.id','=','donaciones.usuario_id')
        ->join('personas', 'personas.id', '=', 'usuarios.persona_id')
        ->select('recolectados.cantidad','recolectados.fecha_recolectado', 'productos.nombre as producto', 'categorias.nombre as categoria', 'personas.nombre', 'personas.primer_apellido', 'personas.segundo_apellido')
        ->where('recolectados.estatus', '1')
        ->where('recolectados.fecha_recolectado','>',$fecha_inicial)
        ->where('recolectados.fecha_recolectado','<',$fecha_final)
        ->orderBy('recolectados.fecha_recolectado')
        ->get();
        
        $response = [
            "data" => $products
        ];
        return response($response, 200);
    }

    public function getProductsByIdDonation($idDonation, $idUser){
        $products = DB::table('recolectados')
            ->join('productos', 'productos.id', '=', 'recolectados.producto_id')
            ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
            ->join('donaciones', 'recolectados.donacion_id', '=', 'donaciones.id')
            ->select('recolectados.*', 'productos.nombre as producto', 'categorias.nombre as categoria')
            ->where('donacion_id', $idDonation)
            ->where('donaciones.usuario_id', $idUser)
            ->orderBy('estatus','desc')
            ->get();

        $response = [
            "data" => $products
        ];
        return response($response, 200);
    }

    public function getProductsOnlyByIdDonation($idDonation){
        $products = DB::table('recolectados')
            ->join('productos', 'productos.id', '=', 'recolectados.producto_id')
            ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
            ->join('donaciones', 'recolectados.donacion_id', '=', 'donaciones.id')
            ->select('recolectados.*', 'productos.nombre as producto', 'categorias.nombre as categoria')
            ->where('donacion_id', $idDonation)
            ->orderBy('estatus','desc')
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
            ->orderBy('estatus','desc')
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
            $currentTime = Carbon::now();
            $picking = Recolectado::find($id);
            $picking->update([
                'cantidad' => $request['cantidad'],
                'caducidad' => $request['caducidad'],
                'estatus' => $request['estatus'],
                'producto_id' => $request['producto_id'],
                'donacion_id' => $request['donacion_id'],
                'fecha_recolectado' => $currentTime->toDateTimeString()
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
        $donation = Recolectado::find($id);
        $status = 0;
        if($donation['estatus'] == 0){
            $status = 1;
        }
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
            "estatus" => $status
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
            'estatus' => 'required|integer|min:0|max:1',
            'producto_id' => 'required|integer',
            'donacion_id' => 'required|integer'
        ], $messages);
        
        if (!$fields->fails()) {

            $products = DB::table('recolectados')
            ->where('donacion_id', $request['donacion_id'])
            ->where('producto_id', $request['producto_id'])
            ->exists();
            
            if($products){
                $response = [
                    "data" => ['El producto ya existe en esa donación'],
                    "estatus" => false
                ];
                return response($response, 200);
            }else{
                $picking = Recolectado::create([
                    'cantidad' => $request['cantidad'],
                    'estatus' => $request['estatus'],
                    'producto_id' => $request['producto_id'],
                    'donacion_id' => $request['donacion_id']
                ]);
                $response = [
                    "data" => $picking,
                    "estatus" => true
                ];
                return response($response, 200);
            }
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
