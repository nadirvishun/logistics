<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pre_order`.
 */
class m170418_085248_create_pre_order_table extends Migration
{
    const TBL_NAME = '{{%pre_order}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="预订单表"';
        }

        $this->createTable(self::TBL_NAME, [
            'order_id' => $this->primaryKey()->comment('订单ID'),
            'order_sn' => $this->bigInteger()->unsigned()->notNull()->comment('订单SN'),
            'region_id' => $this->integer()->notNull()->comment('区域ID'),
            'region_name' => $this->string(50)->notNull()->comment('区域名称'),
            'contact' => $this->string(50)->notNull()->comment('联系人'),
            'mobile' => $this->string(20)->notNull()->comment('联系电话'),
            'address' => $this->string(100)->notNull()->comment('地址'),
            'goods_name' => $this->string(50)->notNull()->comment('货物名称'),
            'goods_weight' => $this->decimal(10, 3)->notNull()->comment('货物重量'),
            'goods_volume' => $this->decimal(10, 3)->notNull()->comment('货物体积'),
            'goods_number' => $this->integer()->notNull()->comment('货物数量'),
            'spec_field'=>$this->string(50)->notNull()->comment('查询出来的对应的区间字段名'),
            'spec_field_name'=>$this->string(50)->notNull()->comment('查询出来的对应的区间名称'),
            'estimate_price' => $this->decimal(10, 2)->notNull()->comment('估算价格'),
            'remark' => $this->string()->notNull()->comment('备注'),
            'is_view' => $this->boolean()->notNull()->comment('是否已查看，0未查看，1已查看'),
            'created_by' => $this->integer()->unsigned()->notNull()->comment('创建人'),
            'created_at' => $this->bigInteger()->unsigned()->notNull()->comment('创建时间'),
            'updated_by' => $this->integer()->unsigned()->notNull()->comment('更新人'),
            'updated_at' => $this->bigInteger()->unsigned()->notNull()->comment('更新时间')
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::TBL_NAME);
    }
}
