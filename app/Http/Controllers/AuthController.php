<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request){
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'integer' => 'El campo :attribute debe ser un número',
            'string' => 'El campo :attribute debe ser un número',
            'confirmed' => 'La contraseñas no coinciden',
            'unique' => 'El usuario ya existe'
        ];

        $fields = Validator::make($request->all(), [
            'contrasenia' => 'required|string|confirmed',
            'usuario' => 'required|string|unique:usuarios,usuario|max:65',
            'rol_id' => 'required|integer',
            'persona_id' => 'required|integer'
        ], $messages);
        
        if (!$fields->fails()) {
            $user = Usuario::create([
                'activo' => true,
                'contrasenia' => bcrypt($request['contrasenia']),
                'usuario' => $request['usuario'],
                'rol_id' => $request['rol_id'],
                'persona_id' => $request['persona_id']
            ]);
    
            $token = $user->createToken('sinara')->plainTextToken;
    
            $response = [
                'user' => $user,
                'token' => $token,
                'estatus' => true
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

    public function login(Request $request){
        $messages = [
            'required' => 'El campo :attribute es obligatorio',
            'max' => 'El campo :attribute no debe ser mayor a :max',
            'string' => 'El campo :attribute debe ser un número'
        ];

        $fields = Validator::make($request->all(), [
            'contrasenia' => 'required|string',
            'usuario' => 'required|string|max:65'
        ], $messages);
        
        if (!$fields->fails()) {

            $user = Usuario::with('rol')
            ->where('usuario', $request['usuario'])
            ->first();
            
            if(!$user || !Hash::check($request['contrasenia'], $user->contrasenia)){
                return response([
                    'estatus' => false,
                    'message' => 'Usuario o contraseña incorrecta'
                ], 200);
            }

            $token = $user->createToken('sinara')->plainTextToken;
    
            $response = [
                'user' => $user,
                'token' => $token,
                'estatus' => true
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

}
