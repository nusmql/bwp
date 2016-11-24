<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use backend\models\Company;
use yii\db\Query;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $company_id
 *
 * @property AuthAssignment[] $authAssignments
 * @property LocalOauth[] $localOauths
 * @property Company $company
 */
class User extends \common\models\User
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_RESETPASSWORD = 'resetpassword';

    public $password;
    // public $password_repeat;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'name', 'first_name', 'last_name', 'company_id'], 'required'],
            [['password'], 'required', 'on' => self::SCENARIO_CREATE],
            [['id', 'status', 'phone_country', 'phone_area', 'phone_number', 'phone_extension', 'created_at', 'updated_at', 'company_id'], 'integer'],
            [['username', 'email', 'password_hash', 'password_reset_token', 'name', 'first_name', 'last_name', 'middle_name'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['mobile'], 'string', 'max' => 45],
            [['username', 'email'], 'unique'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['username', 'email'], 'trim'],
            [
                ['username'], 'unique', 
                'targetAttribute' => 'username', 
                // 'targetClass' => '\common\models\User', 
                'message' => 'This username can not be taken.',
                'when' => function ($model) {
                    return $model->attributeExist(['username' => $model->username]);
                }
            ],
            [
                ['email'], 'unique', 
                'targetAttribute' => 'email', 
                // 'targetClass' => '\common\models\User', 
                'message' => 'This email can not be taken.',
                'when' => function ($model) {
                    return $model->attributeExist(['email' => $model->email]);
                }
            ],
            // [['password_repeat'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_RESETPASSWORD]],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        // $scenarios[self::SCENARIO_CREATE] = ['username', 'email', 'password', 'password_repeat', 'first_name', 'last_name'];
        // $scenarios[self::SCENARIO_RESETPASSWORD] = ['password', 'password_repeat',];

        $scenarios[self::SCENARIO_CREATE] = ['username', 'email', 'password', 'name', 'first_name', 'last_name'];
        $scenarios[self::SCENARIO_RESETPASSWORD] = ['password',];
        return $scenarios;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                $this->setPassword($this->password);
                $this->generateAuthKey();
            }

            return true;
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }


    public static function getStatusListData()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DELETED => 'Disable'
        ];
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

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function attributeExist($attributes = [])
    {
        if (!empty($attributes)) {
            $query = new Query;
            $query->select('id','username')
                ->from('user')
                ->where($attributes);
            return $query->exists();

        } else {
            return false;
        }
    }

}
