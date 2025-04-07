<?php

namespace App\Http\Controllers\Api\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $products = Cache::remember('products', 60, function () {

        if(! $users = User::with('roles')->get())
        {
            throw new NotFoundHttpException('User Not Found');
        }

       });

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:15',
            'email' => 'required|string|email',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'error message' => 'invalid credentials'
            ]);

        }

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->active = true;
            $user->password = Hash::make($request->password);
            $user->save();

            Cache::forget('products'); // Clear all users cache
      

          return response()->json([
            'success' => 'User Created Successfully',
            'user' => $user
          ]);
    }

    public function show($id)
    {
        $product = Cache::remember("user_{$id}", 60, function () use ($id) {

        $user = User::find($id);

        if(! $user) {

           return response()->json('User not found');
         }

        });

        return response()->json($user);
    }

    public function update(Request $request, $id)
     {
        $user = User::find($id);

        if(! $user) {
            throw new NotFoundHttpException('User Not found');
         }
 
         $validator = Validator::make($request->all(), [
             'name' => 'required|string|min:3|max:15',
         ]);
 
         if($validator->fails()) {
             return response()->json([
                 'error message' => 'invalid credentials'
             ]);

         }
 
             $user->name = $request->name;
             $user->update();
       
             Cache::forget("user_{$id}"); // Clear single user cache
             Cache::forget('user'); // Clear all users cache
 
           return response()->json([
             'success' => 'User Created Successfully'
           ]);
     }

     public function destroy($id)
     {
        $user = User::find($id);

        if(! $user) {
            throw new NotFoundHttpException('user not found');
         }

         $user->delete();

         Cache::forget("user_{$id}");
         Cache::forget('user');

         return response()->json('user removed !');
     }

     public function suspend($id)
     {
        $user = User::find($id);

        if(! $user) {
            throw new NotFoundHttpException('user not found');
         }

         $user->active = false;
         $user->save();

         return response()->json([
            'message' => 'User Suspended Successfully'
         ]);
     }

     public function active($id)
     {

        $user = User::find($id);

        if(! $user) {
            throw new NotFoundHttpException('user not found');
         }

         $user->active = true;
         $user->save();

         return response()->json([
            'message' => 'User Been Active Successfully'
         ]);
     }
}
