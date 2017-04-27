<?php

namespace backend\controllers;

use backend\models\BackendSetting;
use backend\models\RegionPrice;
use backend\models\SpecField;
use Yii;
use backend\models\PreOrder;
use backend\models\search\PreOrderSearch;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PreOrderController implements the CRUD actions for PreOrder model.
 */
class PreOrderController extends BaseController
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
     * Lists all PreOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PreOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PreOrder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        //点击时修改阅读状态
        if ($model->is_view == 0) {
            $model->is_view = 1;
            $model->save(false);
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new PreOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PreOrder();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //获取区间字段、区间字段名和计算的价格
            $calcArr = $model->calcPrice($model->goods_weight / 1000, $model->goods_volume, $model->goods_number, $model->region_id);
            foreach ($calcArr as $key => $value) {
                $model->$key = $value;
            }
            //根基传递过来的城市ID获取城市的名称
            $model->region_name = RegionPrice::getRegionOptions($model->region_id);
            //生成订单号
            $model->order_sn = static::genOrderSn();
            if ($model->save(false)) {
                return $this->redirectSuccess(['index'], Yii::t('common', 'Create Success'));
            }
        }
        $model->loadDefaultValues();
        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing PreOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->order_id]);
            return $this->redirectSuccess(['index'], Yii::t('common', 'Update Success'));
        } else {
            if ($model->is_view == 0) {
                $model->is_view = 1;
                $model->save(false);
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PreOrder model.
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
     * Finds the PreOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PreOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PreOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('common', 'The requested page does not exist.'));
        }
    }

    /**
     * 参照shopnc的支付单号编写
     * 生成订单编号(两位随机 + 从2000-01-01 00:00:00 到现在的秒数+微秒+三位随机数)
     * 长度 =2位 + 10位 + 3位 + 3位  = 18位
     * @return string
     */
    public static function genOrderSn()
    {
        return mt_rand(10, 99)
            . sprintf('%010d', time() - 946656000)
            . sprintf('%03d', (float)microtime() * 1000)
            . mt_rand(100, 999);
    }
}
