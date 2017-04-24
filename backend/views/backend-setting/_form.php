<?php

use backend\models\BackendSetting;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BackendSetting */
/* @var $form yii\widgets\ActiveForm */
/* @var $treeOptions backend\controllers\BackendMenuController */
?>

<div class="backend-setting-form">

    <?php $form = ActiveForm::begin([
        'id' => 'backend-setting-form',
        'options' => ['class' => 'box-body']
    ]); ?>

    <?=
    $form->field($model, 'pid', ['options' => ['class' => 'form-group c-md-5']])->widget(Select2::classname(), [
        'data' => $treeOptions,
        'options' => [
            'prompt' => Yii::t('common', 'Please Select...'),
            'encode' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?php $input = $form->field($model, 'alias', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]);
    if (!$model->isNewRecord) {
        echo $input->hint(Yii::t('backend_setting', 'Unless you know it not use in code,otherwise do not change it'));
    } else {
        echo $input;
    } ?>

    <?=
    $form->field($model, 'type', ['options' => ['class' => 'form-group c-md-5']])->widget(Select2::classname(), [
        'data' => BackendSetting::getTypeOptions(),
        'options' => [
            'prompt' => Yii::t('common', 'Please Select...'),
            'encode' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'extra', ['options' => ['class' => 'form-group c-md-6']])->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'hint', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort', ['options' => ['class' => 'form-group c-md-5']])->textInput() ?>

    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group c-md-5']])->widget(SwitchInput::classname(), ['pluginOptions' => ['size' => 'small']]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
