<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m250602_143251_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(64)->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'status' => $this->string()->notNull()->defaultValue('active'),
            'auth_key' => $this->string(32)->null(),
            'access_token' => $this->string(255)->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
