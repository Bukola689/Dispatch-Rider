<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use App\Notifications\WelcomeNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use App\Jobs\ProcessUserRegistration;
//use App\Events\Registered;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $users = User::first();

        // if (!$users) {
        //     return response()->json(['message' => 'User Not Found']);
        // }

        $user = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required' 
        ]);

        $user = User::create([
            'name' => $request->name,
            'active' => true,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token  = $user->createToken('myapptoken')->plainTextToken;

        //send an inatant Notification to the user !!!//

        Notification::sendNow($users, new WelcomeNotification($request->name));

        Mail::to($user->email)->send(new WelcomeMail($user));

        //ProcessUserRegistration::dispatch($user)->delay(now()->addSeconds(5));


        $response = [
            'user'=>$user,
            'token'=>$token,
        ];

        return response($response, 201);
    }
}
