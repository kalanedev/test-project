<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<div class="add-clinic-form">
    <h3>Add Clinic to Professional: <?= Html::encode($professional->name) ?></h3>
    
    <?php $form = ActiveForm::begin([
        'id' => 'add-clinic-form',
        'action' => ['professional/add-clinic', 'professionalId' => $professional->id],
        'options' => ['data-pjax' => true],
    ]); ?>
    
    <?= $form->field($model, 'clinic_id')->dropDownList(
        ArrayHelper::map($availableClinics, 'id', 'description'),
        ['prompt' => 'Select a clinic...']
    ) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
        <?= Html::button('Cancel', [
            'class' => 'btn btn-secondary',
            'id' => 'cancel-add-btn',
            'data-bs-dismiss' => 'modal',
        ]) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>

<?php
    $cancelUrl = \yii\helpers\Url::to(['professional/clinics', 'id' => $professional->id]);
    $js = <<<JS
    $('#add-clinic-form').on('submit', function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            console.log("Server Response:", response);
            if (response && response.success === true) {
                // Simple alert for testing
                alert('Clinic added.');
                
                location.reload(); // Simple solution
            } else {
                alert(response.message || 'Error adding clinic');
                console.error("Errors:", response.errors);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
            console.error("Response:", xhr.responseText);
            alert('There was an error while submitting the form: ' + error);
        }
    });
});
    
    $('#cancel-add-btn').on('click', function() {
        $.ajax({
            url: '{$cancelUrl}',
            type: 'GET',
            success: function(response) {
                $('#clinics-content').html(response);
            }
        });
    });
JS;

$this->registerJs($js);

?>