<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%markup}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $min
 * @property string $max
 * @property integer $markup_ratio
 * @property integer $type
 * @property integer $sort
 * @property integer $status
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 */
class Markup extends \yii\db\ActiveRecord
{
    const STATUS_YES = 1;//显示
    const STATUS_NO = 0;//隐藏
    const TYPE_WEIGHT = 1;//是
    const TYPE_VOLUME = 0;//否

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%markup}}';
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
            ['sort', 'default', 'value' => 0],
            [['name', 'min', 'max', 'type', 'markup_ratio'], 'required'],
            [['min', 'max'], 'number'],
            //当index视图中直接编辑时需要验证
            ['min', 'validateMin', 'on' => 'editable'],
            ['max', 'validateMax', 'on' => 'editable'],
            //最小值小于最大值，只有在更新时验证，需注意type必须为number，否则按照字符串来比较
            ['min', 'compare',
                'compareAttribute' => 'max',
                'operator' => '<',
                'type' => 'number',
                'except' => ['editable']
            ],
            [['type', 'sort', 'status'], 'integer'],
            ['markup_ratio', 'integer', 'min' => 0],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * 直接编辑时由于只传递一个值，所以只能这样验证
     */
    public function validateMin()
    {
        if ($this->min >= $this->max) {
            $this->addError('min', '最小值必须小于最大值');
        }
    }

    /**
     * 接编辑时由于只传递一个值，所以只能这样验证
     */
    public function validateMax()
    {
        if ($this->min >= $this->max) {
            $this->addError('max', '最大值必须大于最小值');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '区间名称',
            'min' => '最小值',
            'max' => '最大值',
            'markup_ratio' => '加价比率',
            'type' => '计算方式',
            'sort' => '排序',
            'status' => '状态',
            'created_by' => '创建人',
            'created_at' => '创建时间',
            'updated_by' => '更新人',
            'updated_at' => '更新时间',
        ];
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
     *  获取下拉菜单列表或者某一名称
     * @param bool $key
     * @return array|mixed
     */
    public static function getTypeOptions($key = false)
    {
        $arr = [
            self::TYPE_WEIGHT => '吨价',
            self::TYPE_VOLUME => '方价'
        ];
        return $key === false ? $arr : ArrayHelper::getValue($arr, $key, Yii::t('common', 'Unknown'));
    }

    /**
     * 获取根据重量和体积获取加价的百分比
     * @param $price
     * @param $weight
     * @param $volume
     * @return false|null|string
     */
    public function getMarkupRatio($price, $weight, $volume)
    {
        $ratio = $weight / $volume;
        $setRatio = BackendSetting::getValueByAlias('markup_ratio');//加价分割点
        //当小于这个比率时，按照吨价计算
        if ($ratio < $setRatio) {
            $markupRatio = static::find()
                ->select('markup_ratio')
                ->where(['>=', 'min', $weight])
                ->andWhere(['<=', 'max', $weight])
                ->andWhere(['status' => self::STATUS_YES, 'type' => self::TYPE_WEIGHT])
                ->scalar();
            $finalPrice = $price * $weight * (1 + $markupRatio / 100);
        } else {//否则按照市价来计算
            $markupRatio = static::find()
                ->select('markup_ratio')
                ->where(['>=', 'min', $volume])
                ->andWhere(['<=', 'max', $volume])
                ->andWhere(['status' => self::STATUS_YES, 'type' => self::TYPE_VOLUME])
                ->scalar();
            $finalPrice = $price * $volume * (1 + $markupRatio / 100);
        }
        return $finalPrice;
    }
}
