<?php

namespace frontend\controllers;

use backend\models\RegionPrice;
use frontend\models\PreOrder;
use Yii;
use yii\helpers\Json;

class PreOrderController extends BaseController
{
    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'main-mobile';
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
            $model->order_sn = $model->genOrderSn();
            if ($model->save(false)) {
                return $this->redirectSuccess(['create'],'提交预约成功，我们工作人员会尽快联系您！');
            }
        }
        $model->loadDefaultValues();
        $model->goods_number = 1;//设置默认的商品数量
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCalcPrice()
    {
        if (Yii::$app->request->isAjax) {
            $model = new PreOrder();
            //获取参数
            $weight = Yii::$app->request->post('weight');
            $volume = Yii::$app->request->post('volume');
            $number = Yii::$app->request->post('number');
            $region_id = Yii::$app->request->post('region_id');
            //计算价格
            $calcArr = $model->calcPrice($weight / 1000, $volume, $number, $region_id);
            $out = Json::encode(['estimate_price' => $calcArr['estimate_price']]);
            echo $out;
        }
    }
}
