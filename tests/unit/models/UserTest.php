<?php
/**
 * Yii2 URL Shortener
 *
 * @copyright Copyright &copy; Sergey Kupletsky, 2018
 * @license MIT
 * @author Sergey Kupletsky <s.kupletsky@gmail.com>
 */

namespace tests\models;

use app\models\User;
use app\tests\_fixtures\UserFixture;
use yii\base\NotSupportedException;

/**
 * Class UserTest
 * @package tests\models
 */
class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @inheritdoc
     */
    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
            ]
        ]);
    }

    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(100));
        expect($user->username)->equals('demo');

        expect_not(User::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        $this->tester->expectException(NotSupportedException::class, function() {User::findIdentityByAccessToken('token');});
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('demo'));
        expect_not(User::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = User::findByUsername('demo');
        expect_that($user->validateAuthKey('test100demoKey'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('demo'));
        expect_not($user->validatePassword('123456'));        
    }

}
