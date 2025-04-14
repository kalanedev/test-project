<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var common\models\Professional $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="professional-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'advice')->dropDownList([ 'CRM' => 'CRM', 'CRO' => 'CRO', 'CRN' => 'CRN', 'COREN' => 'COREN', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'advice_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthdate')->widget(\yii\jui\DatePicker::className(), [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'php:Y-m-d',
        'clientOptions' => [
        'changeMonth' => true,
        'changeYear' => true,
        'yearRange' => '-100:+0',
        ],
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'active' => 'active', 'inactive' => 'inactive', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
