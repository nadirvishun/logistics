<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SpecField */

$this->title = '更新规格';
$this->params['breadcrumbs'][] = ['label' => '规格管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spec-field-update box box-warning">
    <div class="box-header with-border">
        <i class="fa fa-fw fa-pencil"></i>
        <h3 class="box-title"><?= Yii::t('common', 'message_update') ?></h3>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
