<?php

use yii\db\Migration;

/**
 * Handles the creation of table `region_price`.
 */
class m170417_135512_create_region_price_table extends Migration
{
    const TBL_NAME = '{{%region_price}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="区域价格表"';
        }

        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->comment('地区ID'),
            'pid' => $this->integer()->notNull()->comment('地区父ID'),
            'region_name' => $this->string(50)->notNull()->comment('地区名称'),
            'transport_type' => $this->boolean()->unsigned()->notNull()->comment('运输方式，1直达，2中转'),
            'depart_limitation' => $this->decimal(10, 2)->notNull()->comment('发车时效'),
            'transport_limitation' => $this->decimal(10, 2)->notNull()->comment('运输时效'),
            'pickup_limitation' => $this->decimal(10, 2)->notNull()->comment('提货时效'),
            'status' => $this->boolean()->unsigned()->notNull()->defaultValue(1)->comment('状态:0隐藏，1显示'),
            'sort' => $this->integer()->notNull()->defaultValue(0)->comment('排序'),
            'created_by' => $this->integer()->unsigned()->notNull()->comment('创建人'),
            'created_at' => $this->bigInteger()->unsigned()->notNull()->comment('创建时间'),
            'updated_by' => $this->integer()->unsigned()->notNull()->comment('更新人'),
            'updated_at' => $this->bigInteger()->unsigned()->notNull()->comment('更新时间')
        ], $tableOptions);

        $this->insert(self::TBL_NAME, [
            'pid' => 0,
            'region_name' => '福建省',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::TBL_NAME);
    }
}
