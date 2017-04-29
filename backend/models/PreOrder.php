<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%pre_order}}".
 * 由于前台也会用到此模型，所以将共用部分放在common中，然后前台和后台都继承common
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
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className()
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

    /**
     * 获取未读的数量,用户后台上方提示
     */
    public static function getUnViewCount()
    {
        return static::find()
            ->where(['is_view' => self::NO_VIEW])
            ->count();
    }
}
