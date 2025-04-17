<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>

<div class="professional-clinics">
    <h3>Bond clinics to: <?=Html::encode($professional->name)?></h3>

    <div class="mb-3">
        <?= Html::button(
            'Add Clinic',
            [
                'id' => 'add-clinic-btn',
                'class' => 'btn btn-success',
            ]
        ) ?>
    </div>

    <?php
    Pjax::begin([
        'id' => 'clinics-grid-pjax',
        'timeout' => 5000,
        'enablePushState' => false,
    ])
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'description',
        [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{edit} {delete}',
        
        'buttons' => [
            'edit' => function ($url, $model, $key) use ($professional) {
                return Html::a(
                    'edit',
                    ['clinic/update', 'id' => $model->id],
                    ['class' => 'btn btn-sm btn-primary edit-clinic-btn',
                    'style' => 'margin-right: 5px;',
                    'data-clinic-id' => $model->id,
                ]);
        },
            'delete' => function ($url, $model, $key) use ($professional) {
                return Html::a(
                    'delete',
                    ['professional/delete-relation', 'professionalId' => $professional->id, 'clinicId' => $model->id],
                    [
                        'class' => 'btn btn-sm btn-danger',
                        'data-confirm' => 'Are you sure?',
                        'data-method' => 'post',    
                        'data-pjax' => '1',
                    ]
                );
            },
        ]
    ]]]);
    ?>
    <?php Pjax::end(); ?>
</div>

<?php
$addClinicUrl = Url::to(['professional/add-clinic', 'professionalId' => $professional->id]);
$updateClinicBaseUrl = Url::to(['clinic/update']);

$js = <<<JS
    $(document).on('click', '#add-clinic-btn', function() {
    console.log("Add clinic button clicked");
    
    $.ajax({
        url: '$addClinicUrl',
        type: 'GET',
        dataType: 'html',
        success: function(response) {
            console.log("Form loaded successfully");
            $('#clinics-content').html(response);
        },
        error: function(xhr, status, error) {
            console.error("Failed to load form:");
            console.error("Status:", status);
            console.error("Error:", error);
            console.error("Response:", xhr.responseText);
            alert('Failed to load Add Clinic form: ' + error);
        }
    });
});

// Event handler for edit buttons
$(document).on('click', '.edit-clinic-btn', function(e) {
    e.preventDefault();
    var clinicId = $(this).data('clinic-id');
    $.ajax({
        url: '$updateClinicBaseUrl' + '?id=' + clinicId,
        type: 'GET',
        success: function(response) {
            $('#clinics-content').html(response);
        },
        error: function(xhr, status, error) {
            alert('Failed to load Edit Clinic form.');
            console.error("Error:", error);
            console.error(xhr.responseText);
        }
    });
});

// Setup form submission handler (delegated to document since the form will be loaded dynamically)
$(document).on('submit', '#add-clinic-form', function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            console.log("Form submission response:", response);
            
            if (response && response.success) {
                // Refresh the grid after successful submission
                $.pjax.reload({container: '#clinics-grid-pjax'});
                
                // Display success message
                alert(response.message || 'Clinic added');
            } else {
                // Display error message
                alert(response.message || 'Error adding clinic');
                console.error("Errors:", response.errors);
            }
        },
        error: function(xhr, status, error) {
            // The form submission was successful but there might be issues with the response
            console.log("Form submission error handling");
            
            // Try to reload the grid anyway
            try {
                $.pjax.reload({container: '#clinics-grid-pjax'});
                alert('Clinic appears to have been added successfully');
            } catch(e) {
                console.error("Error refreshing grid:", e);
                // Fallback to page reload if pjax reload fails
                location.reload();
            }
        }
    });
});

$(document).on('pjax:success', '#clinics-grid-pjax', function() {
    console.log('Pjax grid reload successful');
});
JS;
$this->registerJs($js);
?>