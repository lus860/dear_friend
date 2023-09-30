<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Repository\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nationality' => $request->nationality,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole(Role::USER); // default role for new users

        // Generate token
        $token = $user->createToken('api_token')->plainTextToken;

        $user = $this->userRepository->getUserById($user->id);

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ], \Illuminate\Http\Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->with(['letters', 'reports', 'roles'])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Generate token
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ], \Illuminate\Http\Response::HTTP_OK);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                $new_user = User::create(
                    ['name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                    ]);
                Auth::login($new_user);
                return response()->json([
                    'success' => true,
                ], \Illuminate\Http\Response::HTTP_OK);
            } else {
                Auth::login($user);
                return response()->json([
                    'success' => true,
                ], \Illuminate\Http\Response::HTTP_OK);
            }

        } catch (\Exception $ex) {
            return self::httpBadRequest($ex->getMessage(), $ex->getCode());
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        // Revoke all tokens for the authenticated user
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json([
            'status' => true,
        ], \Illuminate\Http\Response::HTTP_OK);
    }

    public static function httpBadRequest($error_message, $status = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'success' => false,
            'error_code' => $status,
            'error_message' => __($error_message)
        ], $status);
    }

}

