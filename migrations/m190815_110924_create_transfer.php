<?php

use yii\db\Migration;

/**
 * Class m190815_110924_create_transfer
 */
class m190815_110924_create_transfer extends Migration
{
    private $_tableName = '{{%transfer}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer(10)->notNull(),
            'username_recipient' => $this->string(25)->notNull(),
            'transfer_amount' => $this->float()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->_tableName);
    }



}
