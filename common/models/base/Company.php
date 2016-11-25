<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $name
 * @property string $country
 * @property string $address
 * @property string $address2
 * @property string $province
 * @property string $city
 * @property string $zip
 * @property integer $phone_country
 * @property integer $phone_area
 * @property integer $phone_number
 * @property integer $phone_extention
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'country', 'address', 'province', 'city'], 'required'],
            [['id', 'phone_country', 'phone_area', 'phone_number', 'phone_extention'], 'integer'],
            [['name', 'address', 'address2', 'province', 'city'], 'string', 'max' => 255],
            [['country'], 'string', 'max' => 2],
            [['zip'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'country' => Yii::t('app', 'Country'),
            'address' => Yii::t('app', 'Address'),
            'address2' => Yii::t('app', 'Address2'),
            'province' => Yii::t('app', 'Province'),
            'city' => Yii::t('app', 'City'),
            'zip' => Yii::t('app', 'Zip'),
            'phone_country' => Yii::t('app', 'Phone Country'),
            'phone_area' => Yii::t('app', 'Phone Area'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'phone_extention' => Yii::t('app', 'Phone Extention'),
        ];
    }
}
