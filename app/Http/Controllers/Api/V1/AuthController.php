<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a customer user and their customer profile.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validatedSnake();

        return DB::transaction(function () use ($data): JsonResponse {
            $user = User::query()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => User::ROLE_CUSTOMER,
            ]);

            $customer = Customer::query()->create([
                'user_id' => $user->id,
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'],
                'last_name' => $data['last_name'],
                'house_no' => $data['house_no'],
                'street_name' => $data['street_name'],
                'city' => $data['city'],
                'zip_code' => $data['zip_code'],
                'phone' => $data['phone'],
                'credit_limit' => 0,
            ]);

            $token = $user->createToken('access_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                    ],
                    'customer' => new CustomerResource($customer),
                    'token' => $token,
                ],
            ], 201);
        });
    }

    /**
     * Login and issue a Sanctum token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validatedSnake();
        $user = User::query()->where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials.',
            ], 401);
        }

        $token = $user->createToken('access_token')->plainTextToken;
        $user->load('customer');

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'customer' => $user->customer ? new CustomerResource($user->customer) : null,
                'token' => $token,
            ],
        ], 200);
    }

    /**
     * Logout the current token.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'status' => 'success',
            'data' => null,
        ], 200);
    }

    /**
     * Return the authenticated user profile.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $user->load('customer');

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'customer' => $user->customer ? new CustomerResource($user->customer) : null,
            ],
        ], 200);
    }
}
