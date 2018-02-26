<?php
/**
 * Yii2 URL Shortener
 *
 * @copyright Copyright &copy; Sergey Kupletsky, 2018
 * @license MIT
 * @author Sergey Kupletsky <s.kupletsky@gmail.com>
 */

namespace tests\forms;

use app\models\forms\RegistrationForm;
use app\tests\_fixtures\UserFixture;

/**
 * Class RegistrationFormTest
 * @package tests\forms
 */
class RegistrationFormTest extends \Codeception\Test\Unit
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


    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testRegistrationUsernameExist()
    {
        $form = new RegistrationForm([
            'username'  => 'demo',
            'email'     => 'demo_demo@demo_demo.ru',
            'password'  => 'password',
        ]);

        expect_not($form->signup());
        expect_that(\Yii::$app->user->isGuest);
        expect($form->errors)->hasKey('username');
    }

    public function testRegistrationCorrect()
    {
        $form = new RegistrationForm([
            'username'  => 'demo_demo',
            'email'     => 'demo_demo@demo.ru',
            'password'  => 'demo_demo',
        ]);

        expect_that($form->signup());
        expect_not(\Yii::$app->user->isGuest);
        expect($form->errors)->hasntKey('username');
    }
}
