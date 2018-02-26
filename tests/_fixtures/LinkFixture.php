<?php
/**
 * Yii2 URL Shortener
 *
 * @copyright Copyright &copy; Sergey Kupletsky, 2018
 * @license MIT
 * @author Sergey Kupletsky <s.kupletsky@gmail.com>
 */

namespace app\tests\_fixtures;

use yii\test\ActiveFixture;

/**
 * Class LinkFixture
 * @package app\tests\_fixtures
 */
class LinkFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Link';
    public $dataFile = '@tests/_fixtures/data/link.php';
}