<?php

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Login');
        $I->see('APLibrary');
        $I->click('Login');
        $I->fillField('email', 'test@email.com');
        $I->fillField('password', 'password');
        $I->click('Login');
        $I->see('Logout');
        $I->dontSee('Login');
        $I->see('Search');
        $I->click('Logout');
        $I->see('Login');
        $I->dontSee('Logout');
    }
}
