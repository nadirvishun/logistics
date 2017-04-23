<?php

use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SpecField */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spec-field-form">

    <?php $form = ActiveForm::begin([
        'id' => 'spec-field-form',
        'options' => ['class' => 'box-body']
    ]); ?>

    <?= $form->field($model, 'field_name', ['options' => ['class' => 'form-group c-md-5']])
        ->textInput(['maxlength' => true])->hint('只能包含英文、数字及下划线且以英文开头的字符')
    ?>

    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'min', ['options' => ['class' => 'form-group c-md-5']])
        ->textInput(['maxlength' => true])
        ->hint('保留小数点后三位小数')
    ?>

    <?= $form->field($model, 'max', ['options' => ['class' => 'form-group c-md-5']])
        ->textInput(['maxlength' => true])
        ->hint('保留小数点后三位小数')
    ?>
    <?= $form->field($model, 'sort', ['options' => ['class' => 'form-group c-md-5']])->textInput() ?>
    <?= $form->field($model, 'by_number', ['options' => ['class' => 'form-group c-md-5']])->widget(SwitchInput::classname(), ['pluginOptions' => ['size' => 'small']]) ?>

    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group c-md-5']])->widget(SwitchInput::classname(), ['pluginOptions' => ['size' => 'small']]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common','create') : Yii::t('common','update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
