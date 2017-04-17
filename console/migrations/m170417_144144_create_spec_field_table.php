<?php

use yii\db\Migration;

/**
 * Handles the creation of table `spec_field`.
 */
class m170417_144144_create_spec_field_table extends Migration
{
    const TBL_NAME = '{{%spec_field}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="规格字段表"';
        }

        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->comment('规格ID'),
            'field_name' => $this->string(50)->notNull()->comment('规格字段名称'),
            'name' => $this->string(50)->notNull()->comment('规格名称'),
            'min' => $this->decimal(10, 3)->notNull()->comment('最小值'),
            'max' => $this->decimal(10, 3)->notNull()->comment('最大值'),
            'status' => $this->boolean()->unsigned()->notNull()->defaultValue(1)->comment('状态:0隐藏，1显示'),
            'sort' => $this->integer()->notNull()->defaultValue(0)->comment('排序'),
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
