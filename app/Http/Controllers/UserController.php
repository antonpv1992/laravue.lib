<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Get list of users",
     *     tags={"Users"},
     *     operationId="users/index",
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
     *     @OA\Response(
     *         response="408",
     *         description="Request Timeout",
     *     ),
     *     @OA\Response(
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return response()->json($this->jResponse(true, 'Users index api', UserResource::collection($users)), 200);
    }


    /**
     * @OA\POST(
     *     path="/api/user",
     *     summary="Store a user in storage",
     *     tags={"Users"},
     *     operationId="users/store",
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterRequest $request)
    {
        $user = User::newUser($request);
        return response()->json($this->jResponse(true, 'Users store (created user) api', new UserResource($user)), 200);
    }


    /**
     * @OA\GET(
     *     path="/api/user/{user}",
     *     summary="Show a user from storage",
     *     tags={"Users"},
     *     operationId="users/show",
     *     @OA\Parameter(
     *        name="user",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);
        if(is_null($user)){
            return response()->json($this->jResponse(false, 'User by id = ' . $id . ' not found!', []), 403);
        }
        return response()->json($this->jResponse(true, 'User show api', new UserResource($user)), 200);
    }


    /**
     * @OA\PATCH(
     *     path="/api/user/{user}",
     *     summary="Edit a user in storage",
     *     tags={"Users"},
     *     operationId="users/update",
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::updateUser($request, $id);
        if(is_null($user)){
            return response()->json($this->jResponse(false, 'User by id = ' . $id . ' not found!', []), 403);
        }
        return response()->json($this->jResponse(true, 'Users update (edited user) api', new UserResource($user)), 200);
    }


    /**
     * @OA\DELETE(
     *     path="/api/user/{user}",
     *     summary="Delete a user from storage",
     *     tags={"Users"},
     *     operationId="users/destroy",
     *     @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
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
     *     ),
     *     @OA\Response(
     *         response="408",
     *         description="Request Timeout",
     *     ),
     * )
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = User::deleteUser($id);
        if(is_null($user)){
            return response()->json($this->jResponse(false, 'User by id = ' . $id . ' not found!', []), 400);
        }
        return response()->json($this->jResponse(true, 'Users update (edited user) api', new UserResource($user)), 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
}
