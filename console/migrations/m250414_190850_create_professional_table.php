<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%professional}}`.
 */
class m250414_190850_create_professional_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%professional}}', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string()->notNull(),
            'advice' => $this->string()->notNull(),
            'advice_number' => $this->string()->notNull(),
            'birthdate' => $this->timestamp()->notNull(),
            'status' => $this->boolean()->notNull(),
            'created_at' => $this->timestamp() ]);
            
        $this->execute("ALTER TABLE professional MODIFY advice ENUM('CRM', 'CRO', 'CRN', 'COREN') NOT NULL");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%professional}}');
    }
}
