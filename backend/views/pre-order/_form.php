<?php

use backend\models\RegionPrice;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PreOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pre-order-form">

    <?php $form = ActiveForm::begin([
        'id' => 'pre-order-form',
        'options' => ['class' => 'box-body']
    ]); ?>


    <?=
    $form->field($model, 'region_id', ['options' => ['class' => 'form-group c-md-5']])->widget(Select2::classname(), [
        'data' => RegionPrice::getRegionOptions(false, '潍坊'),
        'options' => [
            'prompt' => Yii::t('common', 'Please Select...'),
            'encode' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'contact', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goods_name', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goods_weight', ['options' => ['class' => 'form-group c-md-5']])
        ->textInput(['maxlength' => true])
        ->hint('单位：千克')
    ?>

    <?= $form->field($model, 'goods_volume', ['options' => ['class' => 'form-group c-md-5']])
        ->textInput(['maxlength' => true])
        ->hint('单位：方')
    ?>

    <?= $form->field($model, 'goods_number', ['options' => ['class' => 'form-group c-md-5']])->textInput() ?>

    <?php //= $form->field($model, 'estimate_price', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark', ['options' => ['class' => 'form-group c-md-6']])->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
