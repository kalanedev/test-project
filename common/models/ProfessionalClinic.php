<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class ProfessionalClinic extends ActiveRecord
{

    public static function tableName() 
    {
        return 'professional_clinic';
    }

    public function rules() 
    {
        return [
            [['professional_id', 'clinic_id'], 'required'],
            [['professional_id', 'clinic_id'], 'integer'],
            [['professional_id', 'clinic_id'], 'unique', 'targetAttribute' => ['professional_id', 'clinic_id']],
            [['professional_id'], 'exist', 'skipOnError' => true, 'targetClass' => Professional::class, 'targetAttribute' => ['professional_id' => 'id']],
            [['clinic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clinic::class, 'targetAttribute' => ['clinic_id' => 'id']],

        ];
    }

    public function getProfessional()
    {
        return $this->hasOne(Professional::class, ['id'=>'professional_id']);
    }

    public function getClinic()
    {
        return $this->hasOne(Clinic::class, ['id' => 'clinic_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert && !$this->created_at) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }

}

?>