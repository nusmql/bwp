<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Reset Password'), ['resetpassword', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'name',
            'first_name',
            'last_name',
            'middle_name',
            'email:email',
            'mobile',
            'phone_country',
            'phone_area',
            'phone_number',
            'phone_extension',
            'status',
            [
                'label' => 'Create Time',
                'value' => Yii::$app->formatter->asDatetime($model->created_at)
            ],
            [
                'label' => 'Update Time',
                'value' => Yii::$app->formatter->asDatetime($model->updated_at)
            ],
            [
                'label' => 'Company',
                'value' => $model->company->name
            ],
        ],
    ]) ?>

</div>
