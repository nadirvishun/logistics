<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
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
class PreOrder extends \yii\db\ActiveRecord
{
    const IS_VIEW = 1;//已查看
    const NO_VIEW = 0;//未查看

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pre_order}}';
    }

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
        return [
            [['region_id', 'contact', 'mobile', 'address', 'goods_name', 'goods_weight', 'goods_volume', 'goods_number'], 'required'],
            //地区ID必须在region_price表中存在
            ['region_id', 'exist',
                'targetClass' => '\backend\models\RegionPrice',
                'targetAttribute' => 'id'
            ],
            [['region_id', 'is_view'], 'integer'],
            ['goods_number', 'integer', 'min' => 1],
            [['goods_weight', 'goods_volume', 'estimate_price'], 'number'],
            [['contact', 'goods_name'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 20],
            ['mobile', 'match', 'pattern' => '/^1(3|4|5|7|8)[0-9]\d{8}$/'],
            [['address'], 'string', 'max' => 100],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => '订单ID',
            'order_sn' => '订单SN',
            'region_id' => '区域ID',
            'region_name' => '区域名称',
            'contact' => '联系人',
            'mobile' => '联系电话',
            'address' => '地址',
            'goods_name' => '货物名称',
            'goods_weight' => '货物重量',
            'goods_volume' => '货物体积',
            'goods_number' => '货物数量',
            'spec_field' => '查询出来的对应的区间字段名',
            'spec_field_name' => '查询出来的对应的区间名称',
            'estimate_price' => '估算价格',
            'remark' => '备注',
            'is_view' => '是否已查看',
            'created_by' => '创建人',
            'created_at' => '创建时间',
            'updated_by' => '更新人',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 是否已查看
     * @param bool $key
     * @return array|mixed
     */
    public static function getViewOptions($key = false)
    {
        $arr = [
            self::NO_VIEW => '未查看',
            self::IS_VIEW => '已查看'
        ];
        return $key === false ? $arr : ArrayHelper::getValue($arr, $key, Yii::t('common', 'Unknown'));
    }

    /**
     * 计算价格
     * @param $weight
     * @param $volume
     * @param $number
     * @param $regionId
     */
    public function calcPrice($weight, $volume, $number, $regionId)
    {
        $initWeight = BackendSetting::getValueByAlias('init_weight');//起步重量
        $initVolume = BackendSetting::getValueByAlias('init_volume');//起步体积
        //实例化地区价格
        $regionPriceModel = new RegionPrice();
        $markupModel = new Markup();
        //如果在起步价格内，则按照件数计算
        if ($weight <= $initWeight && $volume <= $initVolume) {
            $specField = 'init_price';
            $specFieldName = $regionPriceModel->attributeLabels['init_price'];
            //获取区域对应的价格(在此区间内不加价)
            $price = $regionPriceModel->getRegionPrice($regionId, $specField);
            $estimatePrice = empty($price) ? 0 : $price;
        } else {
            $ratio = $weight / $volume;
            $field = SpecField::getFieldNameByRatio($ratio);
            //如果为空，说明没有在任何一个区间内，此时spec_field,spec_field_name,estimate_price都无值
            if (empty($field)) {
                $specField = '';
                $specFieldName = '';
                $estimatePrice = 0;
            } else {
                $specField = $field;
                $specFieldName = $regionPriceModel->attributeLabels[$specField];
                //计算区域价格
                $price = $regionPriceModel->getRegionPrice($regionId, $specField);
                if (!empty($price)) {//如果获取到单位价格
                    //计算最终加价后的价格
                    $estimatePrice = $markupModel->getMarkupRatio($price, $weight, $volume);
                } else {//如果没有获取到单位价格，则也无需加价了
                    $estimatePrice = 0;
                }
            }
        }
        return [
            'spec_field' => $specField,
            'spec_field_name' => $specFieldName,
            'estimate_price' => $estimatePrice
        ];
    }
}
