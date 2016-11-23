<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                   'id',
           'name',
           'username',
           'email:email',
           'status',
           // 'auth_key',
           // 'password_hash',
           // 'password_reset_token',
           // 'first_name',
           // 'last_name',
           // 'middle_name',
           // 'status',
           'mobile',
           // 'phone_country',
           // 'phone_area',
           // 'phone_number',
           // 'phone_extension',
           'created_at',
           'updated_at',
           // 'company_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
