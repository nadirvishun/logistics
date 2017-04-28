<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%pre_order}}".
 *
 * @property integer $order_id
 * @property string $order_sn
 * @property integer $region_id
 * @property string $region_name
 * @property string $contact
 * @property string $mobile
 * @property string $address
 * @property string $goods_name
 * @property string $goods_weight
 * @property string $goods_volume
 * @property integer $goods_number
 * @property string $spec_field
 * @property string $spec_field_name
 * @property string $estimate_price
 * @property string $remark
 * @property integer $is_view
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 */
class PreOrder extends \common\models\PreOrder
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        //只纪录时间的
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [

            ]
        );
    }
}
