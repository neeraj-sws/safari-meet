<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends BaseController
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Admin::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user->tokens()->delete();
        $token = $user->createToken('AdminToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $admin = $request->user();

        if ($admin) {
            $admin->currentAccessToken()->delete();
            return response()->json([
                "status" => true,
                "message" => "Logged out successfully",
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "No authenticated user found",
        ], 401);
    }

    public function profile(Request $request)
    {
        $user = Auth::guard('admin_api')->user();

        if (empty($user)) {
            return response()->json(['status' => false, 'status_code' => 401, 'message' => 'User not authenticated'], 401);
        }
        return $this->sendResponse(['profile' => $request->user()], 'Profile Detail fetched successfully.', null, 200);
    }
}
