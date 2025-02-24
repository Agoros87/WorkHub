<?php

namespace App\Http\Controllers\Api;

/**
 * @group Autenticación
 *
 * APIs para la gestión de autenticación de usuarios
 */
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login
     *
     * Inicia sesión y devuelve el token de acceso.
     *
     * @bodyParam email string required Email del usuario. Example: camarero@restaurante.com
     * @bodyParam password string required Contraseña del usuario. Example: password123
     *
     * @response scenario="success" status=200 {
     *     "token": "2|4CzHh0S4Cq8Z9yIBq6lqW9GjQKz...",
     *     "user": {
     *         "id": 1,
     *         "name": "Juan Pérez",
     *         "email": "camarero@restaurante.com",
     *         "type": "worker",
     *         "created_at": "2025-02-17T23:39:42.000000Z",
     *         "updated_at": "2025-02-17T23:39:42.000000Z"
     *     },
     *     "message": "Login exitoso"
     * }
     * @response status=401 scenario="credenciales incorrectas" {
     *     "message": "Las credenciales proporcionadas son incorrectas."
     * }
     * @response status=422 scenario="validación fallida" {
     *     "message": "Error de validación",
     *     "errors": {
     *         "email": ["El campo email es obligatorio"],
     *         "password": ["El campo password es obligatorio"]
     *     }
     * }
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Las credenciales proporcionadas son incorrectas.',
                ], 401);
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => 'Login exitoso',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Logout
     *
     * Cierra la sesión del usuario actual invalidando el token.
     *
     * @authenticated
     *
     * @response scenario="success" status=200 {
     *     "message": "Logout exitoso"
     * }
     * @response status=500 scenario="error" {
     *     "message": "Error al cerrar sesión",
     *     "error": "Mensaje de error detallado"
     * }
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logout exitoso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al cerrar sesión',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
