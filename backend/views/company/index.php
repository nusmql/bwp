<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Companies');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Company'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'country',
            'address',
            'address2',
            // 'province',
            // 'city',
            // 'zip',
            // 'phone_country',
            // 'phone_area',
            // 'phone_number',
            // 'phone_extention',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
