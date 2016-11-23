<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?> 

	<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?> 

	<?= $form->field($model, 'address2')->textInput(['maxlength' => true]) ?> 

	<?= $form->field($model, 'province')->textInput(['maxlength' => true]) ?> 

	<?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?> 

	<?= $form->field($model, 'zip')->textInput(['maxlength' => true]) ?> 

	<?= $form->field($model, 'phone_country')->textInput() ?> 

	<?= $form->field($model, 'phone_area')->textInput() ?> 

	<?= $form->field($model, 'phone_number')->textInput() ?> 

	<?= $form->field($model, 'phone_extention')->textInput() ?> 


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
