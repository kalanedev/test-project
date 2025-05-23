<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

/** @var yii\web\View $this */
/** @var common\models\Professional $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="professional-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput([
        'maxlength' => true ]) ?>

    <?= $form->field($model, 'advice')->dropDownList([ 
        'CRM' => 'CRM', 
        'CRO' => 'CRO', 
        'CRN' => 'CRN', 
        'COREN' => 'COREN', ], 
        ['prompt' => '']) ?>

    <?= $form->field($model, 'advice_number')->textInput([
        'maxlength' => true]) ?>

    <?= $form->field($model, 'birthdate')->input('date', [ 'class' => 'form-control',
    'min' => (date('Y') - 100) . '-01-01',
    'max' => (date('Y-m-d'))]) ?>

    <?= $form->field($model, 'status')->radioList([
        1 => 'active',
        0 => 'inactive'],
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
