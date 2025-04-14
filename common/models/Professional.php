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
 * @property string $birthdate
 * @property string $status
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

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

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
            [['birthdate'], 'safe'],
            [['status'], 'string'],
            [['name', 'advice_number'], 'string', 'max' => 255],
            ['advice', 'in', 'range' => array_keys(self::optsAdvice())],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
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

    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_ACTIVE => 'active',
            self::STATUS_INACTIVE => 'inactive',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function setStatusToActive()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    public function isStatusInactive()
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    public function setStatusToInactive()
    {
        $this->status = self::STATUS_INACTIVE;
    }

    public function getClinics()
    {
        return $this->hasMany(Clinic::class, ['professional_id'=>'id']);
    }

    public function getProfessional()
    {
        return $this->hasOne(Professional::class, ['id'=>'professional_id']);
    }
}
