<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $name
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property integer $status
 * @property string $mobile
 * @property integer $phone_country
 * @property integer $phone_area
 * @property integer $phone_number
 * @property integer $phone_extension
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $company_id
 */
class User extends \yii\db\ActiveRecord
{
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
    public function rules()
    {
        return [
            [['id', 'username', 'email', 'auth_key', 'password_hash', 'password_reset_token', 'name', 'first_name', 'last_name', 'created_at', 'updated_at', 'company_id'], 'required'],
            [['id', 'status', 'phone_country', 'phone_area', 'phone_number', 'phone_extension', 'created_at', 'updated_at', 'company_id'], 'integer'],
            [['username', 'email', 'password_hash', 'password_reset_token', 'name', 'first_name', 'last_name', 'middle_name'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['mobile'], 'string', 'max' => 45],
            [['email'], 'unique'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
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
}
