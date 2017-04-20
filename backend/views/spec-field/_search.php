<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\SpecFieldSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spec-field-search box box-primary">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'box-body']
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'field_name') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'min') ?>

    <?= $form->field($model, 'max') ?>

    <?php // echo $form->field($model, 'by_number') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'sort') ?>

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
