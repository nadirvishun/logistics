<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SpecField */

$this->title = '查看规格';
$this->params['breadcrumbs'][] = ['label' => '规格管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spec-field-view box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-fw fa-eye"></i>
        <h3 class="box-title"><?= Yii::t('common', 'message_view') ?></h3>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'field_name',
                'name',
                'min',
                'max',
                'sort',
                [
                    'label' => $model->getAttributeLabel('by_number'),
                    'value' => \backend\models\SpecField::getByNumOptions($model->by_number)
                ],
                [
                    'label' => $model->getAttributeLabel('status'),
                    'value' => \backend\models\SpecField::getStatusOptions($model->status)
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
