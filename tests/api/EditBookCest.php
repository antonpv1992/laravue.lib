<?php

class EditBookCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function editBookTest(ApiTester $I)
    {
        $I->wantToTest('edit book is success');
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
        $I->sendPatch('/api/book/25', [
            'title' => 'edit api test',
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

    public function editBookTestFail(ApiTester $I)
    {
        $I->wantToTest('edit book is fail');
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
        $I->sendPatch('/api/book/25', [
            'title' => 'edit api test',
            'description' => '',
            'author' => 'apitest',
            'genre' => '',
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
