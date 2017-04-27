<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\PreOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pre-order-search box box-primary">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'box-body']
    ]); ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'order_sn') ?>

    <?= $form->field($model, 'region_id') ?>

    <?= $form->field($model, 'region_name') ?>

    <?= $form->field($model, 'contact') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'goods_name') ?>

    <?php // echo $form->field($model, 'goods_weight') ?>

    <?php // echo $form->field($model, 'goods_volume') ?>

    <?php // echo $form->field($model, 'goods_number') ?>

    <?php // echo $form->field($model, 'spec_field') ?>

    <?php // echo $form->field($model, 'spec_field_name') ?>

    <?php // echo $form->field($model, 'estimate_price') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'is_view') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('common', 'reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
