<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\RegionPrice */

$this->title = '查看地区价格';
$this->params['breadcrumbs'][] = ['label' => '地区价格', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-price-view box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-fw fa-eye"></i>
        <h3 class="box-title"><?= Yii::t('common', 'message_view') ?></h3>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'pid',
                'region_name',
                'transport_type',
                'depart_limitation',
                'transport_limitation',
                'pickup_limitation',
                'status',
                'sort',
                'created_by',
                'created_at',
                'updated_by',
                'updated_at',
                'first',
                'suibian1',
                'ss',
                'sss',
            ],
        ]) ?>
        <p style="margin-top:10px">
            <?= Html::a(Yii::t('common', 'update'), ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a(Yii::t('common', 'delete'), ['delete', 'id' => $model->id],
                ['class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
        </p>
    </div>
</div>
