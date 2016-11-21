<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use backend\models\Company;

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
            [['name', 'email', 'company_id'], 'required'],
            [['status', 'created_at', 'updated_at', 'company_id'], 'integer'],
            [['name', 'email'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
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
    public function getLocalOauths()
    {
        return $this->hasMany(LocalOauth::className(), ['user_id' => 'id']);
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
}
