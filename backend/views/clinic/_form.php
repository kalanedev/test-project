<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Clinic $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="clinic-form">

    <?php 
        $options = isset($isModal) && $isModal ? ['data-pjax' => '0'] : [];
        $form = ActiveForm::begin([
            'id' => 'clinic-form',
            'options' => $options,
        ]);
    ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    
        <?php if (isset($isModal) && $isModal): ?>
            <?= Html::button('Cancel', [
                'class' => 'btn btn-default',
                'id' => 'cancel-edit-btn',
            ]) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php if (isset($isModal) && $isModal): ?>
<?php
$js = <<<JS
$('#clinic-form').on('beforeSubmit', function(e) {
    e.preventDefault();
    var form = $(this);
    
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            $('#clinics-content').html(response);
        }
    });
    return false;
});

$('#cancel-edit-btn').on('click', function() {
    $.ajax({
        url: '
JS;
$js .= Url::to(['professional/clinics']);
$js .= <<<JS
' + '?id=' + professionalId,
        type: 'GET',
        success: function(response) {
            $('#clinics-content').html(response);
        }
    });
});
JS;

$this->registerJs($js);
?>
<?php endif; ?>
