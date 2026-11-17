<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Dispara o e-mail de boas-vindas (Mailtrap)
        Mail::to($user->email)->send(new WelcomeMail($user));

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'user'    => new UserResource($user),
            'token'   => $token,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login realizado com sucesso!',
            'user'    => new UserResource($user),
            'token'   => $token,
        ], 200);
    }

    public function me(Request $request)
    {
        return new UserResource($request->user());
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        }

        return response()->json([
            'message' => 'Sessão encerrada com sucesso!'
        ], 200);
    }
}