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
 * @property string $first
 * @property string $suibian1
 * @property string $ss
 * @property string $sss
 */
class RegionPrice extends \yii\db\ActiveRecord
{
    const STATUS_YES = 1;//显示
    const STATUS_NO = 0;//隐藏

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
            [['pid', 'region_name', 'transport_type', 'depart_limitation', 'transport_limitation', 'pickup_limitation'], 'required'],
            [['pid', 'transport_type', 'status', 'sort', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['depart_limitation', 'transport_limitation', 'pickup_limitation'], 'number'],
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

        $org = [
            'id' => '地区ID',
            'pid' => '地区父ID',
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
}
