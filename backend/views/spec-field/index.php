<?php

use backend\models\SpecField;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SpecFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '规格管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spec-field-index grid-view box box-primary">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'hover' => true,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => '\kartik\grid\CheckboxColumn',
                'rowSelectedClass' => GridView::TYPE_INFO
            ],
            'id',
            'field_name',
            'name',
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'min',
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'max',
            ],
            /*[
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'by_number',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => SpecField::getByNumOptions(),
                    'options' => [
                        'prompt' => Yii::t('common', 'Please Select...'),
                    ],
                ],
                'value' => function ($model, $key, $index, $column) {
                    return SpecField::getByNumOptions($model->by_number);
                }
            ],*/
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'status',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => SpecField::getStatusOptions(),
                    'options' => [
                        'prompt' => Yii::t('common', 'Please Select...'),
                    ],
                ],
                'value' => function ($model, $key, $index, $column) {
                    return SpecField::getStatusOptions($model->status);
                }
            ],
            'sort',
            // 'created_by',
            // 'created_at',
            // 'updated_by',
            // 'updated_at',

            [
                'class' => '\kartik\grid\ActionColumn',
                'header' => Yii::t('common', 'Actions'),
                'vAlign' => 'middle',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('common', 'view'),
                            'aria-label' => Yii::t('common', 'view'),
                            'data-pjax' => '0',
                            'class' => 'btn btn-xs btn-info'
                        ];
                        return Html::a('<i class="fa fa-fw fa-eye"></i>', ['view', 'id' => $model->id], $options);
                    },
                    'update' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('common', 'update'),
                            'aria-label' => Yii::t('common', 'update'),
                            'data-pjax' => '0',
                            'class' => 'btn btn-xs btn-warning'
                        ];
                        return Html::a('<i class="fa fa-fw fa-pencil"></i>', ['update', 'id' => $model->id], $options);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('common', 'delete'),
                            'aria-label' => Yii::t('common', 'delete'),
                            'data-pjax' => '0',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'class' => 'btn btn-xs btn-danger'
                        ];
                        return Html::a('<i class="fa fa-fw fa-trash"></i>', ['delete', 'id' => $model->id], $options);
                    }
                ],
            ]
        ],
        'panel' => [
            'heading' => false,
            'before' => '<div class="box-header pull-left">
                    <i class="fa fa-fw fa-sun-o"></i><h3 class="box-title">' . Yii::t('common', 'message_manage') . '</h3>
                </div>',
            'after' => '<div class="pull-left" style="margin-top: 8px">{summary}</div><div class="kv-panel-pager pull-right">{pager}</div><div class="clearfix"></div>',
            'footer' => false,
            //'footer' => '<div class="pull-left">'
            //    . Html::button('<i class="glyphicon glyphicon-remove-circle"></i>' . Yii::t('common', 'batch'), ['class' => 'btn btn-primary', 'id' => 'bulk_forbid'])
            //    . '</div>',
            //'footerOptions' => ['style' => 'padding:5px 15px']
        ],
        'panelFooterTemplate' => '{footer}<div class="clearfix"></div>',
        'toolbar' => [
            [
                'content' =>
                    Html::a('<i class="fa fa-plus"></i>', ['create'], ['data-pjax' => 0, 'class' => 'btn btn-success', 'title' => Yii::t('common', 'create')]) . ' ' .
                    Html::a('<i class="fa fa-repeat"></i>', ['index'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('common', 'reset')])
            ],
            '{toggleData}',
            '{export}'
        ],

    ]); ?>
</div>
