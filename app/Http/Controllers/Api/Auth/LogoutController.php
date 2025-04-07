<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request, User $user) 
    {
        $user->tokens()->delete();

        return response()->json('Successfully logged out');
    }
}
