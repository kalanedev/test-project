<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clinic}}`.
 */
class m250414_190801_create_clinic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clinic}}', [
            'id' => $this->primaryKey()->notNull(),
            'description' => $this->text()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clinic}}');
    }
}
