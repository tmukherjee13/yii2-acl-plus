<?php

use tmukherjee13\aclplus\components\Config;

/**
 * Migration table of table_menu
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class m140602_111327_create_menu_table extends \yii\db\Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $menuTable = Config::instance()->menuTable;
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable($menuTable, [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->char(45)->notNull(),
            'route' => $this->char(100),
            'parent' => $this->integer()->defaultValue(0),
            'order' => $this->integer(2),
            'data' => $this->text(),
            'icon' => $this->string(20),
            'status' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(Config::instance()->menuTable);
    }
}
