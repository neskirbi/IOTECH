<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Autenticar usuario opener
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Login(Request $request)
    {
        // Validar campos requeridos
        $request->validate([
            'mail' => 'required|email',
            'pass' => 'required|string|min:4',
        ]);

        // Buscar usuario por email
        $user = DB::table('operadores')
            ->where('mail', $request->mail)
            ->first();

        // Verificar si el usuario existe
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas',
                'user' => null,
                'token' => null
            ], 401);
        }

        // Verificar contraseña (comparar con MD5 o texto plano)
        // Si usas MD5 en la base de datos:
        $passwordMatches = password_verify($request->pass,$user->pass);
        
        // Si usas bcrypt en Laravel:
        // $passwordMatches = Hash::check($request->pass, $user->pass);

        if (!$passwordMatches) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas',
                'user' => null,
                'token' => null
            ], 401);
        }

        // Generar nuevo token de sesión
        $newToken = Str::random(60);
        
        // Actualizar token en la base de datos
        DB::table('operadores')
            ->where('id', $user->id)
            ->update([
                'token' => $newToken,
                'updated_at' => now()
            ]);

        // Preparar respuesta del usuario (sin contraseña)
        $userResponse = [
            'id' => $user->id,
            'id_administrador' => $user->id_administrador,
            'nombres' => $user->nombres,
            'apellidos' => $user->apellidos,
            'mail' => $user->mail,
            'temp' => $user->temp,
            'token' => $newToken,
            'created_at' => $user->created_at,
            'updated_at' => now()->toDateTimeString()
        ];

        // Respuesta exitosa
        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'user' => $userResponse,
            'token' => $newToken
        ], 200);
    }

    /**
     * Cerrar sesión (invalidar token)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Logout(Request $request)
    {
        $token = $request->bearerToken();
        
        if ($token) {
            DB::table('operadores')
                ->where('token', $token)
                ->update(['token' => '']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada exitosamente'
        ], 200);
    }

    /**
     * Verificar token de sesión
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function VerifyToken(Request $request)
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token no proporcionado'
            ], 401);
        }

        $user = DB::table('operadores')
            ->where('token', $token)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido o expirado'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Token válido',
            'user' => [
                'id' => $user->id,
                'nombres' => $user->nombres,
                'apellidos' => $user->apellidos,
                'mail' => $user->mail
            ]
        ], 200);
    }

    /**
     * Obtener perfil del usuario autenticado
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Profile(Request $request)
    {
        $token = $request->bearerToken();
        
        $user = DB::table('operadores')
            ->where('token', $token)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'id_administrador' => $user->id_administrador,
                'nombres' => $user->nombres,
                'apellidos' => $user->apellidos,
                'mail' => $user->mail,
                'temp' => $user->temp,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]
        ], 200);
    }
}