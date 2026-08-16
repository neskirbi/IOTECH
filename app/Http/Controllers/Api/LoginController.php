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
        $validator = validator($request->all(), [
            'mail' => 'required|email',
            'pass' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $user = DB::table('operadores')
            ->where('mail', $request->mail)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        $isTempPassword = false;

        // Si tiene temp (no es null ni vacío), SOLO acepta esa contraseña temporal
        if ($user->temp !== null && $user->temp !== '') {
            if ($user->temp === $request->pass) {
                $isTempPassword = true;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales incorrectas'
                ], 401);
            }
        } else {
            // Si no tiene temp, validar contraseña normal
            $passwordMatches = password_verify($request->pass, $user->pass);
            if (!$passwordMatches) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales incorrectas'
                ], 401);
            }
        }

        // Si es temp, NO generar token ni actualizar nada
        if ($isTempPassword) {
            return response()->json([
                'success' => true,
                'message' => 'Contraseña temporal, debe cambiarla',
                'user' => [
                    'id' => $user->id,
                    'mail' => $user->mail,
                    'temp' => $user->temp
                ],
                'token' => null,
                'requiresPasswordChange' => 1
            ], 200);
        }

        // Si es login normal, generar token
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
            'message' => 'Login exitoso',
            'user' => $userResponse,
            'token' => $newToken,
            'requiresPasswordChange' => 0
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

    // Actualizar contraseña
    DB::table('operadores')
        ->where('id', $userId)
        ->update([
            'pass' => $hashed,
            'temp' => '',
            'updated_at' => now()
        ]);

    // Obtener usuario actualizado
    $user = DB::table('operadores')
        ->where('id', $userId)
        ->first();

    // Generar nuevo token
    $newToken = Str::random(60);

    // Actualizar token
    DB::table('operadores')
        ->where('id', $userId)
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
        'message' => 'Contraseña actualizada correctamente',
        'user' => $userResponse,
        'token' => $newToken
    ], 200);
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