<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\filters\RateLimiter;
use yii\filters\RateLimitInterface;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $name
 * @property string $message
 * @property string|null $ip
 * @property string|null $created_date
 */
class Post extends \yii\db\ActiveRecord
{
    public $captcha;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT =>['created_date'],
                ],
                'value' => time(),
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'message'], 'required'],
            [['name','message'], 'trim'],
            [['created_date'], 'safe'],
            [['name'], 'string', 'max' => 15, 'min' => 2],
            [['message'], 'string', 'max' => 1000, 'min' => 30],
            [['ip'], 'string', 'max' => 100],
            ['captcha', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Автор',
            'message' => 'Сообщение',
            'ip' => 'Ip адрес',
            'created_date' => 'Дата',
            'captcha' => 'Код с картинкы'
        ];
    }

    public function beforeSave($insert)
    {
        $this->ip = Yii::$app->request->userIP;
        $this->name = strip_tags(trim($this->message,['<b>','<i>','<s>']));
        $this->message = strip_tags($this->message,['<b>','<i>','<s>']);

        return parent::beforeSave($insert);
    }

    public function getIpAddress(){
        $result = explode('.',$this->ip);
        if($this->ip)
            return $result[0] . '.' . $result[1] . ".**.**";

        return false;
    }

}
