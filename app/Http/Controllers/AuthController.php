<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Register user baru
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'role' => 'nullable|in:admin,dosen,mahasiswa',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'] ?? 'mahasiswa',
            ]);

            $token = Auth::guard('api')->login($user);

            return response()->json([
                'message' => 'Register berhasil',
                'user' => $user,
                'token' => $token,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $token = Auth::guard('api')->attempt($credentials);

            if (!$token) {
                return response()->json([
                    'message' => 'Email atau password salah',
                ], 401);
            }

            $user = Auth::guard('api')->user();

            return response()->json([
                'message' => 'Login berhasil',
                'user' => $user,
                'token' => $token,
            ], 200);

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get profile user yang login
     */
    public function profile()
    {
        $user = Auth::guard('api')->user();

        return response()->json([
            'message' => 'Data profil',
            'user' => $user,
        ], 200);
    }

    /**
     * Logout
     */
    public function logout()
    {
        try {
            Auth::guard('api')->logout();

            return response()->json([
                'message' => 'Logout berhasil',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Refresh token
     */
    public function refresh()
    {
        try {
            $newToken = Auth::guard('api')->refresh();

            return response()->json([
                'message' => 'Token berhasil di-refresh',
                'token' => $newToken,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal refresh token',
                'error' => $e->getMessage(),
            ], 401);
        }
    }
}