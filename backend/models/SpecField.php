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
            [['min', 'max'], 'number'],
            [['by_number', 'status', 'sort', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['field_name', 'name'], 'string', 'max' => 50],
            [['created_by', 'created_at', 'updated_by', 'updated_at'], 'safe']
        ];
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
            ->orderBy(['sort' => SORT_DESC, 'id' => SORT_ASC])
            ->asArray()
            ->all();
        $arr = [];
        if (!empty($list)) {
            foreach ($list as $item) {
                $arr[$item['field_name']] = $item['name'];
            }
        }
        return $arr;
    }

    /**
     *  获取下拉菜单列表或者某一名称
     * @param bool $status
     * @return array|mixed
     */
    public static function getStatusOptions($status = false)
    {
        $status_array = [
            self::STATUS_NO => '隐藏',
            self::STATUS_YES => '显示'
        ];
        return $status === false ? $status_array : ArrayHelper::getValue($status_array, $status, Yii::t('common', 'Unknown'));
    }

    /**
     *  获取下拉菜单列表或者某一名称
     * @param bool $str
     * @return array|mixed
     */
    public static function getByNumOptions($str = false)
    {
        $str_array = [
            self::BY_NUM_NO => '否',
            self::BY_NUM_YES => '是'
        ];
        return $str === false ? $str_array : ArrayHelper::getValue($str_array, $str, Yii::t('common', 'Unknown'));
    }
}
