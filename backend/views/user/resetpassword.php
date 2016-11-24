<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend/user', 'Reset Password');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend/user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="user-resetpassword">
    <h1><?= Html::encode($this->title)?></h1>

    <div class="resetpassword-form">
	    <?php $form = ActiveForm::begin(); ?>

	    	<?= $form->field($model, 'username')->textInput(['readonly' => !$model->isNewRecord]) ?> 

	    	<?= $form->field($model, 'email')->textInput(['readonly' => !$model->isNewRecord]) ?> 

	    	<?= $form->field($model, 'password')->textInput([
	    			'maxlength' => true,
	    			'placeholder' => Yii::t('backend/user', 'Enter new password'),
	    		]) ?>

	    <div class="form-group">
	        <?= Html::submitButton('Confirm', ['class' => 'btn btn-success']) ?>
	    </div>
	    <?php $form->end(); ?>
    </div>
</div>