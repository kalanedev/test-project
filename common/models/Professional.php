<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "professional".
 *
 * @property int $id
 * @property string $name
 * @property string $advice
 * @property string $advice_number
 * @property date $birthdate
 * @property boolean $status
 */
class Professional extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ADVICE_CRM = 'CRM';
    const ADVICE_CRO = 'CRO';
    const ADVICE_CRN = 'CRN';
    const ADVICE_COREN = 'COREN';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'professional';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'advice', 'advice_number', 'birthdate', 'status'], 'required'],
            [['advice'], 'string'],
            [['advice_number'], 'integer'],
            [['birthdate'], 'date', 'format' => 'php:Y-m-d'],
            [['status'], 'boolean'],
            [['name', 'advice_number'], 'string', 'max' => 255],
            ['advice', 'in', 'range' => array_keys(self::optsAdvice())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'advice' => 'Advice',
            'advice_number' => 'Advice Number',
            'birthdate' => 'Birthdate',
            'status' => 'Status',
        ];
    }


    /**
     * column advice ENUM value labels
     * @return string[]
     */
    public static function optsAdvice()
    {
        return [
            self::ADVICE_CRM => 'CRM',
            self::ADVICE_CRO => 'CRO',
            self::ADVICE_CRN => 'CRN',
            self::ADVICE_COREN => 'COREN',
        ];
    }

    /**
     * @return string
     */
    public function displayAdvice()
    {
        return self::optsAdvice()[$this->advice];
    }

    /**
     * @return bool
     */
    public function isAdviceCrm()
    {
        return $this->advice === self::ADVICE_CRM;
    }

    public function setAdviceToCrm()
    {
        $this->advice = self::ADVICE_CRM;
    }

    /**
     * @return bool
     */
    public function isAdviceCro()
    {
        return $this->advice === self::ADVICE_CRO;
    }

    public function setAdviceToCro()
    {
        $this->advice = self::ADVICE_CRO;
    }

    /**
     * @return bool
     */
    public function isAdviceCrn()
    {
        return $this->advice === self::ADVICE_CRN;
    }

    public function setAdviceToCrn()
    {
        $this->advice = self::ADVICE_CRN;
    }

    /**
     * @return bool
     */
    public function isAdviceCoren()
    {
        return $this->advice === self::ADVICE_COREN;
    }

    public function setAdviceToCoren()
    {
        $this->advice = self::ADVICE_COREN;
    }

    public function getClinics()
    {
        return $this->hasMany(Clinic::class, ['clinic_id'=>'id'])->viaTable('professional_clinic', ['professional_id'=>'id']);
    }

    public function getProfessionalClinics()
    {
        return $this->hasMany(ProfessionalClinic::class, ['professional_id'=>'id']);
    }

}
