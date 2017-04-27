<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PreOrder */

$this->title = 'View Pre Order';
$this->params['breadcrumbs'][] = ['label' => 'Pre Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-order-view box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-fw fa-eye"></i>
        <h3 class="box-title"><?= Yii::t('common', 'message_view') ?></h3>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'order_id',
                'order_sn',
                'region_id',
                'region_name',
                'contact',
                'mobile',
                'address',
                'goods_name',
                'goods_weight',
                'goods_volume',
                'goods_number',
                'spec_field',
                'spec_field_name',
                'estimate_price',
                'remark',
                'is_view',
                'created_by',
                'created_at',
                'updated_by',
                'updated_at',
            ],
        ]) ?>
        <p style="margin-top:10px">
            <?= Html::a(Yii::t('common', 'update'), ['update', 'id' => $model->order_id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a(Yii::t('common', 'delete'), ['delete', 'id' => $model->order_id],
                ['class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
        </p>
    </div>
</div>
