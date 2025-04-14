<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%professional_clinic}}`.
 */
class m250414_190905_create_professional_clinic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%professional_clinic}}', [
            'id' => $this->primaryKey()->notNull(),
            'clinic_id' => $this->integer()->notNull(),
            'professional_id' => $this->integer()->notNull(),
            'additional_data' => $this->string(),
            'created_at' => $this->integer()->notNull() 
        ]);

        $this->addForeignKey(
        'FK-professional_clinic-clinic_id',
        'professional_clinic',
        'clinic_id',
        'clinic',
        'id',
        'CASCADE',
        'CASCADE'
        );

        $this->addForeignKey(
        'FK-professional_clinic-professional_id',
        'professional_clinic',
        'professional_id',
        'professional',
        'id',
        'CASCADE',
        'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%professional_clinic}}');
    }
}
