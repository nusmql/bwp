<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use backend\models\User;
use backend\models\Company;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

$data = Company::getListData();
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php 
        if($model->isNewRecord) {
            echo $form->field($model, 'password');
        }
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
     
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?> 

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?> 

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?> 
    
    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?> 

    <div class="form-inline">
        <?= $form->field($model, 'phone_country')->textInput(['placeholder' => 'code', 'style'=> 'width:90px;'])->label(false) ?> 

        <?= $form->field($model, 'phone_area')->textInput(['placeholder' => 'area', 'style'=> 'width:90px;']) ?> 

        <?= $form->field($model, 'phone_number')->textInput() ?> 

        <?= $form->field($model, 'phone_extension')->textInput(['placeholder' => 'area', 'style'=> 'width:90px;']) ?> 
    </div>

    <?= $form->field($model, 'status')->dropDownList(User::getStatusListData()) ?>

    <?= $form->field($model, 'company_id')->label(\Yii::t('backend/user', 'Company'))->dropDownList($data) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php
        	if(!$model->isNewRecord) {
	        	echo Html::submitButton('Update Password', ['class' => 'btn btn-success']);
        	}
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
