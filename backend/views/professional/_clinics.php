<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>

<div class="professional-clinics">
    <h3>Bond clinics to: <?= Html::encode($professional->name) ?></h3>
    
    <div class="mb-3">
        <?= Html::button(
            'Add Clinic',
            [
                'id' => 'add-clinic-btn',
                'class' => 'btn btn-success',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#clinic-operation-modal'
            ]
        ) ?>
    </div>
    
    <?php
    Pjax::begin([
        'id' => 'clinics-grid-pjax',
        'timeout' => 5000,
        'enablePushState' => false,
    ]);
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
                            'Edit',
                            '#',
                            [
                                'class' => 'btn btn-sm btn-primary update-clinic-btn',
                                'style' => 'margin-right: 5px;',
                                'data-clinic-id' => $model->id,
                                'data-bs-toggle' => 'modal',
                                'data-bs-target' => '#clinic-operation-modal'
                            ]
                        );
                    },
                    'delete' => function ($url, $model, $key) use ($professional) {
                        return Html::a(
                            'Delete',
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
            ]
        ]
    ]); ?>
    
    <?php Pjax::end(); ?>
</div>

<?php
$addClinicUrl = Url::to(['professional/add-clinic', 'professionalId' => $professional->id]);
$updateUrl = Url::to(['clinic/update']);

$js = <<<JS
    $(document).on('click', '#add-clinic-btn', function() {
        $.ajax({
            url: '{$addClinicUrl}',
            type: 'GET',
            success: function(response) {
                $('#clinic-operation-content').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#clinic-operation-content').html('<div class="alert alert-danger">Error loading form: ' + error + '</div>');
            }
        });
    });
    
    $(document).on('click', '.update-clinic-btn', function(e) {
        e.preventDefault();
        var clinicId = $(this).data('clinic-id');
        
        $.ajax({
            url: '{$updateUrl}' + '?id=' + clinicId,
            type: 'GET',
            success: function(response) {
                $('#clinic-operation-content').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#clinic-operation-content').html('<div class="alert alert-danger">Error loading form: ' + error + '</div>');
            }
        });
    });

    $(document).on('pjax:success', '#clinics-grid-pjax', function() {
        console.log('Pjax grid reload successful');
    });
JS;

$this->registerJs($js);
?>