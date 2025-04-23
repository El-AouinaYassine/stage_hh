<?php

   namespace App\Http\Controllers;

   use App\Models\User;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Auth;
   use Illuminate\Support\Facades\Hash;
   use Illuminate\Support\Str;

   class AuthController extends Controller
   {
       public function register(Request $request)
       {
           $validated = $request->validate([
               'name' => 'required|string|max:255',
               'email' => 'required|string|email|max:255|unique:users',
               'password' => 'required|string|min:8',
           ]);
           $token = Str::random(60);
           \Log::info('Generated token: ' . $token);
           $user = User::create([
               'name' => $validated['name'],
               'email' => $validated['email'],
               'password' => Hash::make($validated['password']),
               'api_token' => $token,
           ]);
           \Log::info('User created with token: ' . $user->api_token);
           return response()->json([
               'user' => $user,
               'token' => $user->api_token,
           ], 201);
       }

       public function login(Request $request)
       {
           $request->validate([
               'email' => 'required|email',
               'password' => 'required',
           ]);

           $user = User::where('email', $request->email)->first();

           if (!$user || !Hash::check($request->password, $user->password)) {
               return response()->json(['error' => 'Unauthorized'], 401);
           }

           return response()->json([
               'token' => $user->api_token,
           ]);
       }
   }
