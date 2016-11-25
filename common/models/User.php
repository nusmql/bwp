<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use common\models\Company;
use yii\db\Query;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;
use yii\web\IdentityInterface;


class User extends \common\models\base\User  implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_RESETPASSWORD = 'resetpassword';

    public $password;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => PhoneInputBehavior::className(),
                'phoneAttribute' => 'mobile',
            ],
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
            [['mobile'], PhoneInputValidator::className()],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE] = ['username', 'email', 'password', 'name', 'first_name', 'last_name'];
        $scenarios[self::SCENARIO_UPDATE] = ['username', 'email', 'name', 'first_name', 'last_name'];
        $scenarios[self::SCENARIO_RESETPASSWORD] = ['password'];
        return $scenarios;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                $this->setPassword($this->password);
                $this->generateAuthKey();
            }

            $this->username = strtolower($this->username);

            return true;
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'name' => Yii::t('app', 'Name'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'status' => Yii::t('app', 'Status'),
            'mobile' => Yii::t('app', 'Mobile'),
            'phone_country' => Yii::t('app', 'Phone Country'),
            'phone_area' => Yii::t('app', 'Phone Area'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'phone_extension' => Yii::t('app', 'Phone Extension'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'company_id' => Yii::t('app', 'Company ID'),
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

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
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

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }


    public static function getStatusListData()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DELETED => 'Disable'
        ];
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
