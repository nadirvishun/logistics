<?php

namespace backend\controllers;

use backend\models\SpecField;
use kartik\grid\GridView;
use Yii;
use backend\models\RegionPrice;
use backend\models\search\RegionPriceSearch;
use backend\controllers\BaseController;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RegionPriceController implements the CRUD actions for RegionPrice model.
 */
class RegionPriceController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all RegionPrice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegionPriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //在controller中组装gridView中展示的列
        $gridColumns = [
            [
                'class' => '\kartik\grid\CheckboxColumn',
                'rowSelectedClass' => GridView::TYPE_INFO
            ],
            'id',
            'region_name'
        ];
        $dynamic = SpecField::getFieldNameOptions();
        $specialFields = array_keys($dynamic);
        if (!empty($specialFields)) {
            foreach ($specialFields as $value) {
                $gridColumns[] = [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => $value,
                ];
            }
        }
        $otherColumns = [
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'transport_type',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => RegionPrice::getTransportType(),
                    'options' => [
                        'prompt' => Yii::t('common', 'Please Select...'),
                    ],
                ],
                'value' => function ($model, $key, $index, $column) {
                    return RegionPrice::getTransportType($model->transport_type);
                }
            ],
//            'depart_limitation',
//            'transport_limitation',
//            'pickup_limitation',
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'status',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => RegionPrice::getStatusOptions(),
                    'options' => [
                        'prompt' => Yii::t('common', 'Please Select...'),
                    ],
                ],
                'value' => function ($model, $key, $index, $column) {
                    return RegionPrice::getStatusOptions($model->status);
                }
            ],
            'sort',
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
        ];
        $gridColumns = ArrayHelper::merge($gridColumns, $otherColumns);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gridColumns' => $gridColumns
        ]);
    }

    /**
     * Displays a single RegionPrice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RegionPrice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegionPrice();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirectSuccess(['index'], Yii::t('common', 'Create Success'));
        } else {
            $model->loadDefaultValues();
            $dynamic = SpecField::getFieldNameOptions();
            $specialFields = array_keys($dynamic);
            return $this->render('create', [
                'model' => $model,
                'specialFields' => $specialFields
            ]);
        }
    }

    /**
     * Updates an existing RegionPrice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirectSuccess(['index'], Yii::t('common', 'Update Success'));
        } else {
            $dynamic = SpecField::getFieldNameOptions();
            $specialFields = array_keys($dynamic);
            return $this->render('update', [
                'model' => $model,
                'specialFields' => $specialFields
            ]);
        }
    }

    /**
     * Deletes an existing RegionPrice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirectSuccess(['index'], Yii::t('common', 'Delete Success'));
    }

    /**
     * Finds the RegionPrice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegionPrice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegionPrice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('common', 'The requested page does not exist.'));
        }
    }
}
