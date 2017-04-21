<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\RegionPriceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="region-price-search box box-primary">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'box-body']
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'region_name') ?>

    <?= $form->field($model, 'transport_type') ?>

    <?= $form->field($model, 'depart_limitation') ?>

    <?php // echo $form->field($model, 'transport_limitation') ?>

    <?php // echo $form->field($model, 'pickup_limitation') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'first') ?>

    <?php // echo $form->field($model, 'suibian1') ?>

    <?php // echo $form->field($model, 'ss') ?>

    <?php // echo $form->field($model, 'sss') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('common', 'reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
