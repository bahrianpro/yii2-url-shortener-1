<?php
/**
 * Yii2 URL Shortener
 *
 * @copyright Copyright &copy; Sergey Kupletsky, 2018
 * @license MIT
 * @author Sergey Kupletsky <s.kupletsky@gmail.com>
 */

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "link".
 *
 * @property int    $id
 * @property string $url
 * @property string $description
 * @property string $hash
 * @property int    $counter
 * @property string $expiration
 * @property string $created Дата создания
 * @property int    $created_by Создавший пользователь
 *
 * @property Hit[]  $hits
 * @property User   $owner
 */
class Link extends \yii\db\ActiveRecord
{
    public $short_url = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%link}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class'                 => TimestampBehavior::class,
                'value'                 => function () { return gmdate("Y-m-d H:i:s"); },
                'createdAtAttribute'    => 'created',
                'updatedAtAttribute'    => null,
            ],
            [
                'class'                 => BlameableBehavior::class,
                'createdByAttribute'    => 'created_by',
                'updatedByAttribute'    => null,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'hash'], 'required'],
            [['hash'], 'unique'],
            [['expiration', 'created'], 'safe'],
            [['counter', 'created_by'], 'integer'],
            [['url', 'description', 'hash'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'url'           => 'Адрес ссылки',
            'description'   => 'Описание',
            'hash'          => 'Hash',
            'short_url'     => 'Короткая ссылка',
            'expiration'    => 'Действительна до',
            'counter'       => 'Кол-во переходов',
            'created'       => 'Дата создания',
            'created_by'    => 'Кем создана',
        ];
    }

    /**
     * Convert expiration date to sql format
     *
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if($this->expiration){
            $this->expiration = Yii::$app->formatter->asDate(strtotime($this->expiration), "php:Y-m-d");
        }
        return parent::beforeSave($insert);
    }

    /**
     * Create short_url
     *
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();
        if ($this->short_url === false) {
            $this->short_url = Url::base(true) . '/' . $this->hash;
        }
    }

    /**
     * Generate hash for shorten url
     *
     * @param null $timestamp
     * @return string
     */
    public static function generateHash($timestamp = null)
    {
        if ($timestamp === null) {
            $timestamp = strtotime("now");
        }
        return base_convert($timestamp, 10, 36);
    }

    /**
     * @param $ip
     * @param $ua
     * @return bool
     */
    public function generateHit($ip = null, $ua = null)
    {
        $hit = new Hit();
        $hit->link_id = $this->id;
        $hit->ip = $ip;
        $hit->user_agent = $ua;
        return $hit->save();
    }

    /**
     * Update counter
     */
    public function updateCounter()
    {
        $this->counter++;
        $this->save(false);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        if ($this->expiration) {
            return (strtotime("now")<strtotime($this->expiration));
        }
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHits()
    {
        return $this->hasMany(Hit::class, ['link_id' => 'id']);
    }

    /**
     * @return int
     */
    public function getCountHits()
    {
        return Hit::find()->where(['link_id' => $this->id])->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @inheritdoc
     * @return LinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LinkQuery(get_called_class());
    }

    /**
     * Finds link by hash
     *
     * @param string $hash
     * @return static|null
     */
    public static function findByHash($hash)
    {
        return static::findOne(['hash' => $hash]);
    }
}
