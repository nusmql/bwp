<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $auth_key
 * @property string $password_reset_token
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['username', 'password_hash', 'created_at', 'updated_at', 'auth_key'], 'required'],
        [['created_at', 'updated_at', 'status'], 'integer'],
        [['username', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
        [['auth_key'], 'string', 'max' => 32],
        [['username'], 'unique'],
        [['password_reset_token'], 'unique'],        
        ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'id' => 'ID',
        'username' => 'Username',
        'password_hash' => 'Password Hash',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'status' => 'Status',
        'auth_key' => 'Auth Key',
        'password_reset_token' => 'Password Reset Token',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
        }
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @inheritdoc
     * @return AdminQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminQuery(get_called_class());
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

}
