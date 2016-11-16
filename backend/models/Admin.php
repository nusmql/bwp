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
 * @property integer $create_at
 * @property integer $update_at
 * @property integer $status
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
            [['username', 'password_hash', 'create_at', 'update_at'], 'required'],
            [['create_at', 'update_at', 'status'], 'integer'],
            [['username', 'password_hash'], 'string', 'max' => 255],
            [['username'], 'unique'],
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
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'status' => 'Status',
        ];
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
        var_dump($this->password_hash);exit;
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
          return $this->authKey;
      }
 
      public function validateAuthKey($authKey)
      {
          return $this->authKey === $authKey;
      }
 
}
