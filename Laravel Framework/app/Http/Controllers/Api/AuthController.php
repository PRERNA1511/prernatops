<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Session 20: POST /api/sanctum/login - Authenticate user & issue Bearer Token.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $login = $request->input('login');
        $user = User::where('email', $login)->orWhere('username', $login)->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email/username or password credentials.',
            ], 401);
        }

        // Issue Sanctum plain-text token
        $token = $user->createToken('api_access_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Authentication successful.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ], 200);
    }

    /**
     * Session 20: GET /api/sanctum/user - Protected endpoint requiring Bearer Token.
     */
    public function user(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => 'success',
            'message' => 'Authenticated profile accessed via Sanctum Bearer token.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'profile' => $user->profile,
                'playlists_count' => $user->playlists()->count(),
            ],
        ], 200);
    }

    /**
     * Session 20: POST /api/sanctum/logout - Revoke token.
     */
    public function logout(Request $request)
    {
        // Delete current access token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sanctum API access token revoked successfully.',
        ], 200);
    }
}
