<?php

use yii\db\Migration;

/**
 * Class m190815_112321_index_user_FK_transfer
 */
class m190815_112321_index_user_FK_transfer extends Migration
{
    public function safeUp()
    {
        $this->createIndex(
            'id_username_index',
            '{{%transfer}}',
            'id_user'
        );
        $this->addForeignKey(
            'id_username_fk',
            '{{%transfer}}',
            'id_user',
            '{{%user}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('id_username_fk', '{{%transfer}}');
        $this->dropIndex('id_username_index', '{{%transfer}}');
    }
}
