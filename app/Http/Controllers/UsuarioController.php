<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{

    public function getRecolectorByEstatus($estatus){
        $users = Usuario::with('persona')
        ->where('rol_id',1)
        ->where('activo',$estatus)
        ->get();
        $response = [
            "data" => $users,
            "estatus" => true
        ];
        return response($response, 200);
    }

    public function getRecolectores(){
        $recolector = DB::table('usuarios')
            ->join('personas', 'personas.id', '=', 'usuarios.persona_id')
            ->select('personas.*', 'usuarios.usuario', 'usuarios.activo', 'usuarios.id as usuario_id')
            ->where('rol_id', 1)
            ->orderBy('fecha_registro')
            ->get();

        $response = [
            "data" => $recolector
        ];
        return response($response, 200);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */

    public function updateStatus($id){
        $user = Usuario::find($id);
        if($user->activo == 1){
            $user->update([
                'activo' => 0
            ]);
        }else{
            $user->update([
                'activo' => 1
            ]);
        }
        $response = [
            "data" => $user,
            "estatus" => true
        ];
        return response($response, 200);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'string' => 'El campo :attribute debe ser un número',
        ];

        $fields = Validator::make($request->all(), [
            'usuario' => 'required|string|max:65'
        ], $messages);
        
        if (!$fields->fails()) {
            $user = Usuario::find($id);
            $user->update([
                'usuario' => $request['usuario']
            ]);
            $response = [
                "data" => $user,
                "estatus" => true
            ];
            return response($response, 200);
        }else{
            $response = [
                'data' => $fields->errors(),
                'estatus' => false
            ];
            return response($response, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
