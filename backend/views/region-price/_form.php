<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\RegionPrice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="region-price-form">

    <?php $form = ActiveForm::begin([
        'id' => 'region-price-form',
        'options' => ['class' => 'box-body']
    ]); ?>

    <?= $form->field($model, 'pid', ['options' => ['class' => 'form-group c-md-5']])->textInput() ?>

    <?= $form->field($model, 'region_name', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transport_type', ['options' => ['class' => 'form-group c-md-5']])->textInput() ?>

    <?= $form->field($model, 'depart_limitation', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transport_limitation', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pickup_limitation', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group c-md-5']])->textInput() ?>

    <?= $form->field($model, 'sort', ['options' => ['class' => 'form-group c-md-5']])->textInput() ?>

    <?= $form->field($model, 'created_by', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_by', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'suibian1', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sss', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common','create') : Yii::t('common','update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
