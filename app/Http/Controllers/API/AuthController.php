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


    public function promoteToHR(Request $request, $userId)
    {

        if (auth()->user()->role !== 'superadmin') {
            return response()->json(['message' => 'Yetkiniz yok!'], 403);
        }


        $user = User::find($userId);


        if ($user) {
            $user->update(['role' => 'hr']);
            return response()->json(['message' => 'User promoted to HR successfully!']);
        }

        return response()->json(['message' => 'User not found!'], 404);
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
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        if ($user->role === 'employee' || $user->role === 'hr') {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Unauthorized role.'], 403);
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
}
