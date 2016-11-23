<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "company".
 *
 * @property string $name
 * @property integer $id
 *
 * @property User[] $users
 */
class Company extends \common\models\Company
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['company_id' => 'id']);
    }


    public static function getListData()
    {
        // prepare company list data
        $data = self::find()
            ->select(['id', 'name'])
            ->asArray()
            ->all();

        return  ArrayHelper::map($data, 'id', 'name');
    }

    public function attributeLabels()
    {
        $attributes = parent::attributeLabels();

        $attributes['phone_country'] = Yii::t('app', 'Code');
        $attributes['phone_area'] = Yii::t('app', 'Area');
        $attributes['phone_number'] = Yii::t('app', 'Number');
        $attributes['phone_extention'] = Yii::t('app', 'Extension');

        return $attributes;
    }
}
