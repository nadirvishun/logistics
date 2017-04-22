<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\RegionPrice */
/* @var $specialFields backend\controllers\RegionPriceController*/

$this->title = '创建地区价格';
$this->params['breadcrumbs'][] = ['label' => '地区价格', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-price-create box box-success">
    <div class="box-header with-border">
        <i class="fa fa-fw fa-plus"></i>
        <h3 class="box-title"><?= Yii::t('common', 'message_create') ?></h3>
    </div>
    <?=
    $this->render('_form', [
        'model' => $model,
        'specialFields'=>$specialFields
    ]) ?>
</div>
