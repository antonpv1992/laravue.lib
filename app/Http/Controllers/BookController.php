<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/book",
     *     summary="Get list of books",
     *     tags={"Books"},
     *     operationId="books/index",
     *     @OA\Parameter(
     *        name="sort",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *      @OA\Parameter(
     *        name="order",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *      @OA\Parameter(
     *        name="filter",
     *        in="query",
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *      @OA\Parameter(
     *        name="search",
     *        in="query",
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success, message, data, pagination",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/Book")
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
    public function index(Request $request)
    {
        $book = Book::getBooks($request);
        return response()->json([
            'success' => true,
            'message' => 'Books index api paginate',
            'data' => BookResource::collection($book),
            'pagination' => [
                'current_page' => json_decode($book->toJson())->current_page ?? 1,
                'last_page' => json_decode($book->toJson())->last_page ?? 1,
                'per_page' => json_decode($book->toJson())->per_page ?? Book::count(),
                'total'=> json_decode($book->toJson())->total ?? Book::count(),
                'from' => json_decode($book->toJson())->from ?? 1,
                'to' => json_decode($book->toJson())->to ?? Book::count()
            ]
        ], 200);
    }


    /**
     * @OA\POST(
     *     path="/api/book",
     *     summary="Store a book in storage",
     *     tags={"Books"},
     *     operationId="books/store",
     *     @OA\Parameter(
     *        name="title",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="description",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="image",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="image"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="author",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="genre",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="country",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="book",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="year",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="pages",
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
     *             @OA\Items(ref="#/definitions/Book")
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
     * @param  \App\Http\Requests\BookRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookRequest $request)
    {
        $book = Book::newBook($request);
        return response()->json($this->jResponse(true, 'Books store (created book) api', new BookResource($book)), 200);
    }

    /**
     * @OA\GET(
     *     path="/api/book/{book}",
     *     summary="Get a book from storage",
     *     tags={"Books"},
     *     operationId="books/show",
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
     *             @OA\Items(ref="#/definitions/Book")
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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $book = Book::find($id);
        if(is_null($book)){
            return response()->json($this->jResponse(false, 'Book by id = ' . $id . ' not found!', []), 403);
        }
        return response()->json($this->jResponse(true, 'Book show api', new BookResource($book)), 200);
    }


     /**
     * @OA\PATCH(
     *     path="/api/book/{book}",
     *     summary="Edit a book in storage",
     *     tags={"Books"},
     *     operationId="books/edit",
     *     @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="title",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="description",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="image",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="image"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="author",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="genre",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="country",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="book",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="year",
     *        in="query",
     *        required=true,
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
     *     @OA\Parameter(
     *        name="pages",
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
     *             @OA\Items(ref="#/definitions/Book")
     *         ),
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Book not found",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/Book")
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
     *         response="408",
     *         description="Request Timeout",
     *     ),
     * )
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BookRequest $request //\Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BookRequest $request, $id)
    {
        $book = Book::updateBook($request, $id);
        if(is_null($book)){
            return response()->json($this->jResponse(false, 'Book by id = ' . $id . ' not found!', []), 403);
        }
        return response()->json($this->jResponse(true, 'Books update (edited book) api', new BookResource($book)), 200);
    }

    /**
     * @OA\DELETE(
     *     path="/api/book/{book}",
     *     summary="Delete a book from storage",
     *     tags={"Books"},
     *     operationId="books/destroy",
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
     *             @OA\Items(ref="#/definitions/Book")
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
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $book = Book::deleteBook($id);
        if(is_null($book)){
            return response()->json($this->jResponse(false, 'Book by id = ' . $id . ' not found!', []), 400);
        }
        return response()->json($this->jResponse(true, 'Books update (edited book) api', new BookResource($book)), 200);
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
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $book = Book::find($id);
        return response()->json($this->jResponse(true, 'Books edit (edit page) api', new BookResource($book)), 200);
    }
}
