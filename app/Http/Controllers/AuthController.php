<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use App\Http\Resources\RegisterResource;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use Illuminate\​Support\Facades\Session;
use Illuminate\Auth\Events\Verified;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\PasswordReset;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class AuthController extends Controller
{

    /**
     * @OA\POST (
     *     path="/api/login",
     *     summary="login user",
     *     tags={"Auth"},
     *     operationId="users/login",
     *     @OA\Parameter(
     *        name="email",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="email"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="password",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="password"
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success, message, data",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/User")
     *         ),
     *     ),
     *    @OA\Response(
     *         response=401,
     *         description="Invalid email/password"
     *    ),
     *    @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response="408",
     *         description="Request Timeout",
     *     ),
     * )
     */
    /**
     * Login api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try{
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                /** @var User $user */
                $user = Auth::user();
                $user->token = $user->createToken('Laravue')->accessToken;
                return response()->json($this->jResponse(true, 'User login api', new LoginResource($user)), 200);
            }
        }catch(\Exception $exception){
            return response()->json($this->jResponse(false, $exception->getMessage(), []), 400);
        }
        return response()->json($this->jResponse(false, 'Invalid email/password', []), 401);
    }


    /**
     * @OA\POST(
     *     path="/api/register",
     *     summary="Register user",
     *     tags={"Auth"},
     *     operationId="users/register",
     *     @OA\Parameter(
     *        name="login",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="email",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="email"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="password",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="password"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="password_confirmation",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="password"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="surname",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="age",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success, message, data",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/User")
     *         ),
     *     ),
     *     @OA\Response(
     *         response="408",
     *         description="Request Timeout",
     *     ),
     *    @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *    ),
     *    @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    /**
     * Register api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $pass = $request->password;
            $user = User::create(
                array_merge($request->all(), ['password' => bcrypt($request->password)])
            );
            event(new Registered($user));
            $user->attachRole('user');
            if(Auth::attempt(['email' => $user->email, 'password' => $pass]))//, true))
            {
                $user = Auth::user();
                 /** @var User $user */
                $user->token = $user->createToken('Laravue')->accessToken;
                return response()->json($this->jResponse(true, 'User register api', new RegisterResource($user)), 200);
            };
            $user->token = $user->createToken('Laravue')->accessToken;
            return response()->json($this->jResponse(true, 'User register but not authorized api', new RegisterResource($user)), 200);
        } catch(\Exception $exception){
            return response()->json($this->jResponse(false, $exception->getMessage(), []), 400);
        }
    }


     /**
     * @OA\POST(
     *     path="/api/logout",
     *     summary="logout user",
     *     tags={"Auth"},
     *     operationId="users/logout",
     *      security={
     *      {
     *      "passport": {}},
     *      },
     *     @OA\Response(
     *         response=200,
     *         description="success, message, data",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/User")
     *         ),
     *     ),
     *    @OA\Response(
     *         response=401,
     *         description="Invalid email/password"
     *    ),
     *    @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response="408",
     *         description="Request Timeout",
     *     ),
     * )
     */
    /**
     * Logout api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        /** @var User $user */
        if(!Auth::user()){
            return response()->json($this->jResponse(false, 'User is not logged in', []), 400);
        }
        $user = Auth::user();
        /** @var User $user */
        $user->token()->revoke();

        $user->tokens()->each(function($token, $key) {
            $token->delete();
        });

        return response()->json($this->jResponse(true, 'User logout api', new UserResource($user)), 200);
    }


     /**
     * @OA\POST(
     *     path="/api/forgot",
     *     summary="forgot password",
     *     tags={"Auth"},
     *     operationId="users/forgot",
     *     @OA\Parameter(
     *        name="email",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="email"
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success, message, data",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/User")
     *         ),
     *     ),
     *    @OA\Response(
     *         response=401,
     *         description="Invalid email/password"
     *    ),
     *    @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response="408",
     *         description="Request Timeout",
     *     ),
     * )
     */
    /**
     *
     */
    public function forgot(ForgotRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user === null){
            return response()->json($this->jResponse(false, 'User doesn\'t exists', []), 404);
        }
        try{
            $sendEmail = Password::sendResetLink(
                $request->only('email')
            );
            return $sendEmail == Password::RESET_LINK_SENT
                              ? response()->json($this->jResponse(true, 'Check your email', new UserResource($user)), 200)
                              : response()->json($this->jResponse(false, 'Error sending letter', new UserResource($user)), 404);
        } catch(\Exception $exception){
            return response()->json($this->jResponse(false, $exception->getMessage(), []), 400);
        }

    }


    /**
     * @OA\POST(
     *     path="/api/reset",
     *     summary="reset password",
     *     tags={"Auth"},
     *     operationId="users/reset",
     *     @OA\Parameter(
     *        name="email",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="email"
     *        )
     *     ),
     *      @OA\Parameter(
     *        name="password",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="password"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="password_confirmation",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="password"
     *        )
     *     ),
     *      @OA\Parameter(
     *        name="token",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success, message, data",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/User")
     *         ),
     *     ),
     *    @OA\Response(
     *         response=401,
     *         description="Invalid email/password"
     *    ),
     *    @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response="408",
     *         description="Request Timeout",
     *     ),
     * )
     */
    /**
     *
     */
    public function reset(ResetRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();
            }
        );
        return $status == Password::PASSWORD_RESET
                               ? response()->json($this->jResponse(true, 'Password was changed successfully', []), 200)
                               : response()->json($this->jResponse(false, 'Password change error', []), 404);

    }


     /**
     * @OA\POST (
     *     path="/api/verify/{id}/{hash}",
     *     summary="verify email",
     *     tags={"Auth"},
     *     operationId="users/verify",
     *     @OA\Parameter(
     *        name="email",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="email"
     *        )
     *     ),
     *      @OA\Parameter(
     *        name="id",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="hash",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *      @OA\Parameter(
     *        name="signature",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="expires",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success, message, data",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/User")
     *         ),
     *     ),
     *      security={
     *      {
     *      "passport": {}},
     *      },
     *    @OA\Response(
     *         response=401,
     *         description="Invalid email/password"
     *    ),
     *    @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response="408",
     *         description="Request Timeout",
     *     ),
     * )
     */
    /**
     *
     */
    public function verify(EmailVerificationRequest $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json($this->jResponse(false, 'Invalid/Expired url provided', new UserResource(Auth::user())), 401);
        }
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json($this->jResponse(false, 'Mail already verified', new UserResource(Auth::user())), 200);
        }
        $request->user()->markEmailAsVerified();
        event(new Verified($request->user()));
        return response()->json($this->jResponse(true, 'Mail verified successfully', new UserResource(Auth::user())), 200);
    }


    /**
     * @OA\POST (
     *     path="/api/verify/",
     *     summary="resend email",
     *     tags={"Auth"},
     *     operationId="users/resend",
     *     security={
     *      {
     *      "passport": {}},
     *      },
     *     @OA\Response(
     *         response=200,
     *         description="success, message, data",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/User")
     *         ),
     *     ),
     *    @OA\Response(
     *         response=401,
     *         description="Invalid email/password"
     *    ),
     *    @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *    ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response="408",
     *         description="Request Timeout",
     *     ),
     * )
     */
    /**
     *
     */
    public function resend()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return response()->json($this->jResponse(false, 'Mail already verified', new UserResource(Auth::user())), 200);
        }
        Auth::user()->sendEmailVerificationNotification();
        return response()->json($this->jResponse(true, 'Verification message sent successfully', new UserResource(Auth::user())), 200);
    }



     /**
     *
     */
    public function viewVerify(Request $request)
    {
        return response()->json($this->jResponse(true, 'Mail already verified', new UserResource($request->all())), 200);
    }
}