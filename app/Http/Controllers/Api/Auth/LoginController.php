<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

      $user = User::where('email', $data['email'])->first();

      if(!$user || !Hash::check($data['password'], $user->password))
      {
          return response(['message'=>'invalid credentials'], 401);
      } else {
        $token  = $user->createToken('myapptoken')->plainTextToken;
      }

      $when = Carbon::now()->addSeconds(10);

      // Notification::sendNow($users, new WelcomeNotification($request->name));

       $user->verify((new RegisterNotification($user))->delay($when));

       //Dispatch the Notification//

       event(new UserRegistered($user));

        // Dispatch the job
        
        ProcessUserRegistration::dispatch($user)
        ->delay(now()->addSeconds(30));

        $response = [
            'user'=>$user,
            'token'=>$token,
        ];

        Cache::put('user');

        return response($response, 200);
      }
    
}
