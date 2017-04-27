<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%region_price}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $init_price
 * @property string $region_name
 * @property integer $transport_type
 * @property string $depart_limitation
 * @property string $transport_limitation
 * @property string $pickup_limitation
 * @property integer $status
 * @property integer $sort
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 */
class RegionPrice extends \yii\db\ActiveRecord
{
    const STATUS_YES = 1;//显示
    const STATUS_NO = 0;//隐藏
    const TYPE_DIRECT = 1;//直达
    const TYPE_TRANSFER = 2;//中转

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%region_price}}';
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
        $org = [
            //设定默认的值，否则不填写时为null，写入数据库时与not null冲突
            [['depart_limitation', 'transport_limitation', 'pickup_limitation', 'sort'], 'default', 'value' => 0],
            [['pid', 'region_name', 'init_price', 'transport_type'], 'required'],
            [['pid', 'transport_type', 'status', 'sort', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['init_price', 'depart_limitation', 'transport_limitation', 'pickup_limitation'], 'number'],
            [['region_name'], 'string', 'max' => 50],
        ];
        //获取动态的验证内容
        $dynamic = SpecField::getFieldNameOptions();
        if (!empty($dynamic)) {
            $add = [
                [array_keys($dynamic), 'required'],
                [array_keys($dynamic), 'number']
            ];
            $org = ArrayHelper::merge($org, $add);
        }
        return $org;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $initWeight = BackendSetting::getValueByAlias('init_weight');//起步重量
        $initVolume = BackendSetting::getValueByAlias('init_volume');//起步体积
        $init_price=$initWeight.'T/'.$initVolume.'方内';
        $org = [
            'id' => '地区ID',
            'pid' => '上级地区',
            'init_price' => $init_price,
            'region_name' => '地区名称',
            'transport_type' => '运输方式',
            'depart_limitation' => '发车时效',
            'transport_limitation' => '运输时效',
            'pickup_limitation' => '提货时效',
            'status' => '状态',
            'sort' => '排序',
            'created_by' => '创建人',
            'created_at' => '创建时间',
            'updated_by' => '更新人',
            'updated_at' => '更新时间',
        ];
        $add = SpecField::getFieldNameOptions();
        if (!empty($add)) {
            $org = ArrayHelper::merge($org, $add);
        }
        return $org;
    }

    /**
     *  获取下拉菜单列表或者某一名称
     * @param bool $key
     * @return array|mixed
     */
    public static function getStatusOptions($key = false)
    {
        $arr = [
            self::STATUS_NO => '隐藏',
            self::STATUS_YES => '显示'
        ];
        return $key === false ? $arr : ArrayHelper::getValue($arr, $key, Yii::t('common', 'Unknown'));
    }

    /**
     *  获取运输方式的方法
     * @param bool $key
     * @return array|mixed
     */
    public static function getTransportType($key = false)
    {
        $arr = [
            self::TYPE_DIRECT => '直达',
            self::TYPE_TRANSFER => '中转'
        ];
        return $key === false ? $arr : ArrayHelper::getValue($arr, $key, Yii::t('common', 'Unknown'));
    }

    /**
     * 获取顶级的省份
     * 目前只有福建省，后续扩展时可能用到
     * @param bool $key
     * @return array|mixed
     */
    public static function getRootOptions($key = false)
    {
        $arr = static::find()
            ->select(['region_name', 'id'])
            ->where(['pid' => 0, 'status' => self::STATUS_YES])
            ->indexBy('id')
            ->asArray()
            ->column();
        return $key === false ? $arr : ArrayHelper::getValue($arr, $key, Yii::t('common', 'Unknown'));
    }

    /**
     * 根据地区相关的下拉菜单货单个数据
     * @param bool|integer $id
     * @param bool|string $originRegion 如果包含始发地，需将始发地名称传递
     * @return string
     */
    public static function getRegionOptions($id = false, $originRegion = false)
    {
        $arr = static::find()
            ->select(['region_name', 'id'])
            ->where(['!=', 'pid', 0])
            ->andWhere(['status' => self::STATUS_YES])
            ->indexBy('id')
            ->asArray()
            ->column();
        //如果包含始发地,则名称中需要展示始发地信息
        if ($originRegion !== false && !empty($arr)) {
            foreach ($arr as $key => $value) {
                $arr[$key] = $originRegion . '-----' . $value;
            }
        }
        return $id === false ? $arr : ArrayHelper::getValue($arr, $id, Yii::t('common', 'Unknown'));
    }

    /**
     * 根据地区ID和对应的区间来获取价格
     * @param $regionId
     * @param $fieldName
     * @return false|null|string
     */
    public function getRegionPrice($regionId, $fieldName)
    {
        return static::find()
            ->select($fieldName)
            ->where(['id' => $regionId, 'status' => self::STATUS_YES])
            ->scalar();
    }
}
