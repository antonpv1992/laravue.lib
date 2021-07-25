<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


/**
 * @OA\Schema(
 *     title="Book",
 *     description="Book model",
 *     @OA\Xml(
 *         name="Book"
 *     )
 * )
 */
class Book extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'image',
        'author',
        'genre',
        'country',
        'year',
        'pages',
        'book'
    ];

    protected $casts = [
        'year' => 'integer',
        'pages' => 'integer'
    ];

    public static function newBook(BookRequest $request)
    {
        $book = new self($request->all());
        if($request->file('image')){
            $path = Storage::putFile('public', $request->file('image'));
            $url = Storage::url($path);
        } else {
            $url = '/images/book.jpg';
        }
        $book->image = $url;
        $book->save();
        return $book;
    }

    public static function updateBook(BookRequest $request, int $id)
    {
        $book = self::find($id);
        if(is_null($book)){
            return null;
        }
        if($request->file('image')) {
            $path = Storage::putFile('public', $request->file('image'));
            $url = Storage::url($path);
            $request->image = $url;
        }
        $book->update($request->all());
        return $book;
    }

    public static function deleteBook(int $id)
    {
        $book = self::find($id);
        if(is_null($book)){
            return null;
        }
        $book->delete();
        return $book;
    }

    public static function getBooks(Request $request)
    {
        $sort = $request->sort;
        $order = ($request->order && $request->order === 'up') ? 'asc' : 'desc';
        $book = self::where(function($query) use ($request) {
            if(isset($request->filter)){
                foreach ($request->filter as $key => $value) {
                    $query->orWhere($value, 'LIKE', '%' . $request->search . '%');
                }
            }
        })->orderBy($sort, $order)->paginate($request->limit)->appends(request()->query());
        return $book;
    }
}