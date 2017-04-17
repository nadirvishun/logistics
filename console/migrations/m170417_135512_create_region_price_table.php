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
            'pid'=>$this->integer()->notNull()->comment('地区父ID'),
            ''
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::TBL_NAME);
    }
}
