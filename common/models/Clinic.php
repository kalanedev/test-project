<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "clinic".
 *
 * @property int $id
 * @property string $description
 */
class Clinic extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
        ];
    }

    public function getProfessionals()
    {
        return $this->hasMany(Professional::class, ['id'=>'professional_id'])->viaTable('professional_clinic', ['clinic_id'=>'id']);
    }

    public function getProfessionalClinics()
    {
        return $this->hasMany(ProfessionalClinic::class, ['clinic_id'=>'id']);
    }
}
