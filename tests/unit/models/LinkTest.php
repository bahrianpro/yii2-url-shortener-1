<?php
/**
 * Yii2 URL Shortener
 *
 * @copyright Copyright &copy; Sergey Kupletsky, 2018
 * @license MIT
 * @author Sergey Kupletsky <s.kupletsky@gmail.com>
 */

namespace tests\models;

use app\models\Link;
use app\tests\_fixtures\LinkFixture;
use app\tests\_fixtures\UserFixture;

/**
 * Class LinkTest
 * @package tests\models
 */
class LinkTest extends \Codeception\Test\Unit
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
            ],
            'link' => [
                'class' => LinkFixture::class,
            ]
        ]);
    }

    public function testGenerateLinksHash()
    {
        expect(Link::generateHash('10167810'))->equals('61xj6');
        expect(Link::generateHash('99'))->notEquals('61xj6');
    }

    public function testFindLinkByHash()
    {
        expect_that($link = Link::findByHash('test100'));
        expect($link->hash)->equals('test100');

        expect_not(Link::findByHash('test99'));
    }

    public function testUpdateLinkCounter()
    {
        $link = Link::findOne(100);
        $link->updateCounter();
        expect($link->counter)->equals(101);
        expect($link->counter)->notEquals(100);
    }

    public function testCheckLinkStatus()
    {
        $link = Link::findOne(100);
        expect($link->isActive())->equals(true);


        $link = Link::findOne(101);
        expect($link->isActive())->equals(false);
    }
}
