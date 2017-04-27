<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PreOrder */

$this->title = 'Update Pre Order';
$this->params['breadcrumbs'][] = ['label' => 'Pre Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-order-update box box-warning">
    <div class="box-header with-border">
        <i class="fa fa-fw fa-pencil"></i>
        <h3 class="box-title"><?= Yii::t('common', 'message_update') ?></h3>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
