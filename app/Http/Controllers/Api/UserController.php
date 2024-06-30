<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tokens;
use App\Http\Requests\UserTokenRequest;

class UserController extends Controller
{
    public function createToken(UserTokenRequest $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !password_verify($request->password, $user->password)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid credentials'], 401);
        }

        $token = Tokens::create([
            'user_id' => $user->id,
            'token' => bin2hex(random_bytes(32)),
        ]);

        return response()->json([
            'status' => 'success',
            'token' => $token->token,
        ]);
    }
}
