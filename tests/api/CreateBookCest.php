<?php

use \Illuminate\Database\Eloquent\Factory;

class CreateBookCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function createBookTest(ApiTester $I)
    {
        $I->wantToTest('creat book is success');
        $user = \App\Models\User::factory()->make([
            'id' => 30,
            'login' => 'apitest',
            'email' => 'apitest@mail.org',
            'password' => bcrypt('password'),
            'name' => 'api',
            'surname' => 'test',
            'age' => 19
        ]);
        $user->attachRole('admin');
        $token = $user->createToken('Laravue')->accessToken;
        $I->amBearerAuthenticated($token);
        $I->sendPost('/api/book', [
            'title' => 'api test',
            'description' => 'api test description',
            'author' => 'apitest',
            'genre' => 'apitest',
            'country' => 'apitest',
            'year' => 2020,
            'pages' => 200,
            'book' => 'api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text'
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['success' => true]);
    }

    public function createBookTestFail(ApiTester $I)
    {
        $I->wantToTest('creat book is fail');
        $user = \App\Models\User::factory()->make([
            'id' => 30,
            'login' => 'apitest',
            'email' => 'apitest@mail.org',
            'password' => bcrypt('password'),
            'name' => 'api',
            'surname' => 'test',
            'age' => 19
        ]);
        $user->attachRole('admin');
        $token = $user->createToken('Laravue')->accessToken;
        $I->amBearerAuthenticated($token);
        $I->sendPost('/api/book', [
            'title' => '',
            'description' => 'api test description',
            'author' => 'apitest',
            'genre' => 'apitest',
            'country' => 'apitest',
            'year' => 2020,
            'pages' => 200,
            'book' => 'api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text
                       api test text api test text api test text api test text api test text api test text api test text api test text'
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['success' => false]);
    }
}
