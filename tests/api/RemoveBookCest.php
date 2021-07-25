<?php

class RemoveBookCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function removeBookTest(ApiTester $I)
    {
        $I->wantToTest('remove book is success');
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
        $I->sendDelete('/api/book/25');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['success' => true]);
    }

    public function removeBookTestFail(ApiTester $I)
    {
        $I->wantToTest('remove book is fail');
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
        $I->sendDelete('/api/book/30');
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['success' => false]);
    }
}
