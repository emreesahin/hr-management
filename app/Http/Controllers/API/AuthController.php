<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     try {

    //         $credentials = $request->validate([
    //             'email' => 'required|email',
    //             'password' => 'required'
    //         ]);


    //         if (!Auth::attempt($credentials)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Wrong Credentials',
    //                 'data' => []
    //             ], 401);
    //         }


    //         $user = Auth::user();


    //         if (!$user->hasRole('hr')) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Permission Denied',
    //                 'data' => []
    //             ], 403);
    //         }


    //         $token = $user->createToken('auth_token')->plainTextToken;

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Login successful',
    //             'access_token' => $token,
    //             'token_type' => 'Bearer'
    //         ], 200);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Internal Server Error',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }


    public function promoteToHR($userId)
    {
        try {
            $user = User::find($userId);

            // Authenticatied user
            $authUser = auth()->user();

            // Superadmin rolü kontrolü
            if (!$authUser || !$authUser->hasRole('superadmin')) {
                return response()->json(['error' => 'Only superadmin can promote users to HR.'], 403);
            }

            // Kullanıcıyı HR rolüne terfi ettir
            if ($user) {
                $user->assignRole('hr');
                return response()->json(['message' => 'User promoted to HR successfully.'], 200);
            } else {
                return response()->json(['error' => 'User not found.'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }




    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',
        ]);

        return response()->json(['message' => 'User created successfully!'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Geçersiz e-posta veya şifre.'],
            ]);
        }

        // Spatie/Permission kullanıyorsanız:
        // if (!$user->hasRole(['employee', 'hr', 'superadmin'])) {
        //     return response()->json(['message' => 'Yetkisiz rol.'], 403);
        // }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully',
            'data' => []
        ], 200);
    }

    public function getUserInfo (Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => true,
            'message' => 'User info',
            'data' => $user
        ], 200);

    }
}
