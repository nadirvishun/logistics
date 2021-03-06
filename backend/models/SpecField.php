<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%spec_field}}".
 *
 * @property integer $id
 * @property string $field_name
 * @property string $name
 * @property string $min
 * @property string $max
 * @property integer $by_number
 * @property integer $status
 * @property integer $sort
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 */
class SpecField extends \yii\db\ActiveRecord
{
    const STATUS_YES = 1;//显示
    const STATUS_NO = 0;//隐藏
    const BY_NUM_YES = 1;//是
    const BY_NUM_NO = 0;//否

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%spec_field}}';
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
            ['status', 'default', 'value' => self::STATUS_YES],
            ['by_number', 'default', 'value' => self::BY_NUM_NO],
            ['status', 'in', 'range' => [self::STATUS_YES, self::STATUS_NO]],
            ['by_number', 'in', 'range' => [self::BY_NUM_NO, self::BY_NUM_YES]],
            ['sort', 'default', 'value' => 0],
            [['field_name', 'name', 'min', 'max'], 'required'],
            ['field_name', 'match', 'pattern' => '/^[a-z]\w*$/'],
            ['field_name', 'unique'],
            //不能与region_price表字段名重复，只适用于新增，更新时由于牵扯到自身字段导致不能有效判定
            ['field_name', 'in',
                'not' => true,
                'range' => array_keys(Yii::$app->db->getTableSchema(RegionPrice::tableName())->columns),
                'on' => 'insert'
            ],
            //更新时同样不能重复，适用于更新时验证
            ['field_name', 'validateFieldName', 'on' => 'update'],
            [['min', 'max'], 'number', 'min' => 0],
            //当index视图中直接编辑时需要验证
            ['min', 'validateMin', 'on' => 'editable'],
            ['max', 'validateMax', 'on' => 'editable'],
            //最小值小于最大值，只有在更新时验证，需注意type必须为number，否则按照字符串来比较
            ['min', 'compare',
                'compareAttribute' => 'max',
                'operator' => '<',
                'type' => 'number',
                'on' => ['insert', 'update']
            ],
            [['by_number', 'status', 'sort', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['field_name', 'name'], 'string', 'max' => 50],
            [['created_by', 'created_at', 'updated_by', 'updated_at'], 'safe'],
        ];
    }

    /**
     * 更新字段名时不能与region_price表中字段重复
     * 同时需要排除自身原有的
     */
    public function validateFieldName()
    {
        //先判定传递的值是否有变动，没有变动则直接不验证
        if ($this->isAttributeChanged('field_name', false)) {
            //如果有变动，则判定新的字段是否在region_price表中已存在
            $regionPriceFields = array_keys(Yii::$app->db->getTableSchema(RegionPrice::tableName())->columns);
            if (in_array($this->field_name, $regionPriceFields)) {
                $this->addError('field_name', '字段名称已存在，请重新选择名称');
            }
        }
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
            'id' => '规格ID',
            'field_name' => '规格字段名',
            'name' => '规格名称',
            'min' => '最小值',
            'max' => '最大值',
            'by_number' => '按件数计算',
            'status' => '状态',
            'sort' => '排序',
            'created_by' => '创建人',
            'created_at' => '创建时间',
            'updated_by' => '更新人',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取field_name的字段数组，[field_name=>name]格式
     */
    public static function getFieldNameOptions()
    {
        $list = self::find()
            ->select('name,field_name')
            ->where(['status' => 1])
            ->indexBy('field_name')
            ->orderBy(['sort' => SORT_DESC, 'id' => SORT_ASC])
            ->asArray()
            ->column();
        return $list;
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
    public static function getByNumOptions($key = false)
    {
        $arr = [
            self::BY_NUM_NO => '否',
            self::BY_NUM_YES => '是'
        ];
        return $key === false ? $arr : ArrayHelper::getValue($arr, $key, Yii::t('common', 'Unknown'));
    }

    /**
     * 根据比率来查询对应的字段名
     * @param $ratio
     * @return false|null|string
     */
    public function getFieldNameByRatio($ratio)
    {
        return static::find()
            ->select('field_name')
            ->where(['<=', 'min', $ratio])
            ->andWhere(['>=', 'max', $ratio])
            ->andWhere(['status' => self::STATUS_YES])
            ->scalar();
    }
}
