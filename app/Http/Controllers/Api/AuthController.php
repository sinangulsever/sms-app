<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Models\User;

class AuthController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(path="/auth/login",summary="Login User get token",tags={"Auth"},
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(type="object",required={"email","password"},
     *           @OA\Property(property="email", type="string", example="sinan@gmail.com",description="User's email"),
     *          @OA\Property(property="password", type="string", example="1233",description="User's password"),
     *        )
     *     ),
     *     @OA\Response(response="200", description="Login success", @OA\JsonContent(ref="#/components/schemas/LoginResource")),
     *     @OA\Response(response="422", description="Validation errors", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     *     @OA\Response(response="500", description="Server error", @OA\JsonContent(ref="#/components/schemas/ApiResponse"))
     * )
     *
     * @param LoginRequest $request
     * @return LoginResource|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): LoginResource|\Illuminate\Http\JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');
            if (!$token = auth('api')->attempt($credentials)) {
                return rj(false, "Kullanıcı e-mail adresi veya şifre hatalı !", null, 401);
            }
            $object = new \stdClass();
            $object->token = $token;
            return new LoginResource($object);
        } catch (\Throwable $ex) {
            return rj(false, 'M:' . $ex->getMessage(), null, 500);
        }
    }


    /**
     * @OA\Post(path="/auth/register",summary="Register User",tags={"Auth"},
     *     @OA\RequestBody(required=true,
     *          @OA\JsonContent(type="object",required={"customer_id","email","password","password_confirmation"},
     *            @OA\Property(property="customer_id", type="integer", example="1",description="User's customer_id"),
     *            @OA\Property(property="name", type="string", example="Sinan",description="User's name"),
     *            @OA\Property(property="email", type="string", example="sinan@gmail.com",description="User's email"),
     *            @OA\Property(property="password", type="string", example="1233",description="User's password"),
     *            @OA\Property(property="password_confirmation", type="string", example="1233",description="User's password_confirmation"),
     *         )
     *      ),
     *     @OA\Response(response="201", description="Register success", @OA\JsonContent(ref="#/components/schemas/UserResource")),
     *     @OA\Response(response="422", description="Validation errors", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     *     @OA\Response(response="500", description="Server error", @OA\JsonContent(ref="#/components/schemas/ApiResponse"))
     * )
     *
     * @param RegisterRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */

    public function register(RegisterRequest $request): UserResource|\Illuminate\Http\JsonResponse
    {
        try {
            $user = new User($request->all());

            if (!$user->save()) {
                return rj(false, "Kayıt işlemi başarısız !", null, 500);
            }
            return new UserResource($user);
        } catch (\Throwable $ex) {
            return rj(false, 'M:' . $ex->getMessage(), null, 500);
        }
    }

    /**
     *
     * @OA\Get(
     *     path="/auth/user",summary="Get User",tags={"Auth"},security={{"bearerAuth":{}}},
     *     @OA\Response(response="201", description="Get user success",@OA\JsonContent(ref="#/components/schemas/UserResource")),
     *     @OA\Response(response="500", description="Server error", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     *     @OA\Response(response="401", description="Unauthorized",@OA\JsonContent(ref="#/components/schemas/UnAuthorized")
     *    ),
     * )
     *
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function user(): UserResource|\Illuminate\Http\JsonResponse
    {
        try {
            $user = auth('api')->user();
            return new UserResource($user);
        } catch (\Throwable $ex) {
            return rj(false, 'M:' . $ex->getMessage(), null, 500);
        }
    }


}
