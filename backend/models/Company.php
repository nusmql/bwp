<?php

namespace backend\models;

use Yii;

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
}
