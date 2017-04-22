<?php

use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\RegionPrice */
/* @var $form yii\widgets\ActiveForm */
/* @var $specialFields backend\controllers\RegionPriceController */
?>

<div class="region-price-form">

    <?php $form = ActiveForm::begin([
        'id' => 'region-price-form',
        'options' => ['class' => 'box-body']
    ]); ?>

    <?= $form->field($model, 'pid', ['options' => ['class' => 'form-group c-md-5']])->widget(Select2::classname(), [
        'data' => \backend\models\RegionPrice::getRootOptions(),
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'region_name', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?php foreach ($specialFields as $value) {
        echo $form->field($model, $value, ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]);
    } ?>

    <?= $form->field($model, 'transport_type', ['options' => ['class' => 'form-group c-md-5']])->widget(Select2::classname(), [
        'data' => \backend\models\RegionPrice::getTransportType(),
        'options' => [
            'prompt' => Yii::t('common', 'Please Select...'),
            'encode' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'depart_limitation', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transport_limitation', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pickup_limitation', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort', ['options' => ['class' => 'form-group c-md-5']])->textInput() ?>

    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group c-md-5']])->widget(SwitchInput::classname(), ['pluginOptions' => ['size' => 'small']]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
