<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m221228_065626_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(15)->notNull(),
            'message' => $this->string(1000)->notNull(),
            'ip' => $this->string(100)->null(),
            'created_date' => $this->timestamp()->null()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post}}');
    }
}
