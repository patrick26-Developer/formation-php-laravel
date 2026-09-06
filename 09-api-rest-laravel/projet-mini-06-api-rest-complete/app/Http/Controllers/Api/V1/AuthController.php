<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            // Message volontairement générique (module 02.6) : ne jamais
            // révéler si c'est l'email OU le mot de passe qui est incorrect.
            return response()->json(['message' => 'Identifiants invalides.'], 401);
        }

        $jeton = $user->createToken('api-mobile')->plainTextToken;

        return response()->json(['token' => $jeton, 'token_type' => 'Bearer']);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnecté.']);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'id' => $request->user()->id,
            'nom' => $request->user()->name,
            'email' => $request->user()->email,
        ]);
    }
}
