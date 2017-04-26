<?php

use yii\db\Migration;

/**
 * Handles the creation of table `markup`.
 */
class m170426_125724_create_markup_table extends Migration
{
    const TBL_NAME = '{{%markup}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="加价设置表"';
        }

        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->comment('ID'),
            'name' => $this->string(50)->notNull()->comment('区间名称'),
            'min' => $this->decimal(10, 3)->notNull()->comment('最小值'),
            'max' => $this->decimal(10, 3)->notNull()->comment('最大值'),
            'markup_ratio' => $this->boolean()->unsigned()->notNull()->defaultValue(0)->comment('加价比率，单位%'),
            'type' => $this->boolean()->unsigned()->notNull()->comment('1为吨价，2为方价'),
            'sort' => $this->integer()->notNull()->defaultValue(0)->comment('排序'),
            'status' => $this->boolean()->unsigned()->notNull()->defaultValue(1)->comment('状态:0隐藏，1显示'),
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
