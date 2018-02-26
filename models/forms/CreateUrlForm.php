<?php
/**
 * Yii2 URL Shortener
 *
 * @copyright Copyright &copy; Sergey Kupletsky, 2018
 * @license MIT
 * @author Sergey Kupletsky <s.kupletsky@gmail.com>
 */

namespace app\models\forms;

use app\models\Link;
use yii\base\Model;

/**
 * Class CreateUrlForm
 *
 * @package app\models\forms
 */
class CreateUrlForm extends Model
{
    public $url;
    public $description;
    public $expiration;

    private $hash = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['url', 'trim'],
            ['url', 'required'],
            [['expiration'], 'safe'],
            [['url', 'description'], 'string', 'max' => 255],
            ['url', 'validateHash'],
        ];
    }

    /**
     * Generate and validate hash.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateHash($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->hash = Link::generateHash();
            if (Link::findByHash($this->hash)) {
                $this->addError($attribute, 'Не удалось создать короткую ссылку, попробуйте еще раз.');
            }
        }
    }

    /**
     * Create shorten link.
     *
     * @return Link|null the saved model or null if saving fails
     */
    public function createLink()
    {
        if (!$this->validate()) {
            return null;
        }
        $link = new Link();
        $link->url = $this->url;
        $link->description = $this->description;
        $link->expiration = $this->expiration;
        $link->hash = $this->hash;
        return $link->save() ? $link : null;
    }
}
