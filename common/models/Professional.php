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
 * @property string $stats
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

    const STATS_ACTIVE = 'active';
    const STATS_INACTIVE = 'inactive';

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
            [['name', 'advice', 'advice_number', 'birthdate', 'stats'], 'required'],
            [['advice'], 'string'],
            [['birthdate'], 'safe'],
            [['stats'], 'string'],
            [['name', 'advice_number'], 'string', 'max' => 255],
            ['advice', 'in', 'range' => array_keys(self::optsAdvice())],
            ['stats', 'in', 'range' => array_keys(self::optsStats())],
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
            'stats' => 'Stats',
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
     * column stats ENUM value labels
     * @return string[]
     */
    public static function optsStats()
    {
        return [
            self::STATS_ACTIVE => 'active',
            self::STATS_INACTIVE => 'inactive',
        ];
    }

    /**
     * @return string
     */
    public function displayStats()
    {
        return self::optsStats()[$this->stats];
    }

    /**
     * @return bool
     */
    public function isStatsActive()
    {
        return $this->stats === self::STATS_ACTIVE;
    }

    public function setStatsToActive()
    {
        $this->stats = self::STATS_ACTIVE;
    }

    public function isStatsInactive()
    {
        return $this->stats === self::STATS_INACTIVE;
    }

    public function setStatsToInactive()
    {
        $this->stats = self::STATS_INACTIVE;
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
