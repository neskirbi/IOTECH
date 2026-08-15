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
        $request->validate([
            'mail' => 'required|email',
            'pass' => 'required|string|min:4',
        ]);

        $user = DB::table('operadores')
            ->where('mail', $request->mail)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas',
                'user' => null,
                'token' => null
            ], 401);
        }

        $isTempPassword = false;

        if ($user->temp && $user->temp === $request->pass) {
            $isTempPassword = true;
        } else {
            $passwordMatches = password_verify($request->pass, $user->pass);
            if (!$passwordMatches) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales incorrectas'
                ], 401);
            }
        }

        $newToken = Str::random(60);
        
        DB::table('operadores')
            ->where('id', $user->id)
            ->update([
                'token' => $newToken,
                'updated_at' => now()
            ]);

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

        return response()->json([
            'success' => true,
            'message' => $isTempPassword ? 'Contraseña temporal, debe cambiarla' : 'Login exitoso',
            'user' => $userResponse,
            'token' => $newToken,
            'requires_password_change' => $isTempPassword
        ], 200);
    }
    /**
     * Cerrar sesión (invalidar token)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */


    public function changePassword(Request $request) {
        $userId = $request->userId;
        $newPassword = $request->newPassword;

        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

        DB::table('operadores')
            ->where('id', $userId)
            ->update([
                'pass' => $hashed,
                'temp' => null,
                'updated_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada'
        ]);
    }


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