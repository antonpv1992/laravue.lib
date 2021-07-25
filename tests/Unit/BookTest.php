<?php

class BookTest extends \Codeception\Test\Unit
{

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $book = \Codeception\Stub::make(App\Models\Book::class);
        $request = new Illuminate\Http\Request([
            'limit' => '8',
            'search' => '',
            'sort' => 'id',
            'order' => 'asc',
            'filter' => ['title']
        ]);
        $this->assertCount(8, App\Models\Book::getBooks($request));
        $this->assertNotEmpty(App\Models\Book::getBooks($request));
        $this->assertNotInstanceOf(App\Models\Book::class, App\Models\Book::getBooks($request));
        $this->assertIsObject(App\Models\Book::getBooks($request));
        $this->assertNotNull(App\Models\Book::getBooks($request));
        $this->assertSame(null, $book->title);
    }
}