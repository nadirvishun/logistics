<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Markup */

$this->title = '查看加价区间';
$this->params['breadcrumbs'][] = ['label' => 'Markups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markup-view box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-fw fa-eye"></i>
        <h3 class="box-title"><?= Yii::t('common', 'message_view') ?></h3>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'min',
                'max',
                [
                    'label' => $model->getAttributeLabel('markup_ratio'),
                    'value' => $model->markup_ratio.'%'
                ],
                [
                    'label' => $model->getAttributeLabel('type'),
                    'value' => \backend\models\Markup::getTypeOptions($model->type)
                ],
                'sort',
                [
                    'label' => $model->getAttributeLabel('status'),
                    'value' => \backend\models\Markup::getStatusOptions($model->status)
                ],
                [
                    'label' => $model->getAttributeLabel('created_by'),
                    'value' => \backend\models\Admin::getUsernameById($model->created_by)
                ],
                'created_at:datetime',
                [
                    'label' => $model->getAttributeLabel('updated_by'),
                    'value' => \backend\models\Admin::getUsernameById($model->updated_by)
                ],
                'updated_at:datetime',
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
