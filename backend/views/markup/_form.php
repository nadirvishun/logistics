<?php

use backend\models\Markup;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Markup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="markup-form">

    <?php $form = ActiveForm::begin([
        'id' => 'markup-form',
        'options' => ['class' => 'box-body']
    ]); ?>

    <?=
    $form->field($model, 'type', ['options' => ['class' => 'form-group c-md-5']])->widget(Select2::classname(), [
        'data' => Markup::getTypeOptions(),
        'options' => [
            'prompt' => Yii::t('common', 'Please Select...'),
            'encode' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>
    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'min', ['options' => ['class' => 'form-group c-md-5']])
        ->textInput(['maxlength' => true])
        ->hint('保留小数点后三位小数')
    ?>

    <?= $form->field($model, 'max', ['options' => ['class' => 'form-group c-md-5']])
        ->textInput(['maxlength' => true])
        ->hint('保留小数点后三位小数')
    ?>

    <?= $form->field($model, 'markup_ratio', ['options' => ['class' => 'form-group c-md-5']])
        ->textInput()
        ->hint('单位：%')
    ?>

    <?= $form->field($model, 'sort', ['options' => ['class' => 'form-group c-md-5']])->textInput() ?>

    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group c-md-5']])->widget(SwitchInput::classname(), ['pluginOptions' => ['size' => 'small']]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common','create') : Yii::t('common','update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
