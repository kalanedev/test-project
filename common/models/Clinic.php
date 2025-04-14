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

    public function getProfessional()
    {
        return $this->hasOne(Professional::class, ['id'=>'professional_id']);
    }

}
