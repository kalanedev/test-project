<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
?>

<div class="professional-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <ul class="nav nav-tabs" id="professionalTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="principal-tab" data-bs-toggle="tab" data-bs-target="#principal" 
                    type="button" role="tab" aria-controls="principal" aria-selected="true">
                Principal
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="clinics-tab" data-bs-toggle="tab" data-bs-target="#clinics" 
                    type="button" role="tab" aria-controls="clinics" aria-selected="false">
                Clinics
            </button>
        </li>
    </ul>
    
    <div class="tab-content" id="professionalTabsContent">
        <div class="tab-pane fade show active p-3" id="principal" role="tabpanel" aria-labelledby="principal-tab">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'advice',
                    'advice_number',
                    'birthdate',
                    [
                        'attribute' => 'status',
                        'value' => $model->status ? 'active' : 'inactive',
                    ]
                ],
            ]) ?>
        </div>
        
        <div class="tab-pane fade p-3" id="clinics" role="tabpanel" aria-labelledby="clinics-tab">
            <div id="clinics-content">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    Modal::begin([
        'id' => 'clinic-operation-modal',
        'title' => '<h4>Clinic Operation</h4>',
        'size' => 'lg',
        'bodyOptions' => [
            'id' => 'clinic-operation-content',
        ],
    ]);
    echo '<div class="text-center"><div class="spinner-border" role="status"></div></div>';
    Modal::end();
    ?>
</div>

<?php
$clinicsUrl = Url::to(['professional/clinics', 'id' => $model->id]);

$js = <<<JS
    $('#clinics-tab').on('click', function(e) {
        if (!$(this).data('loaded')) {
            $.ajax({
                url: '{$clinicsUrl}',
                type: 'GET',
                success: function(response) {
                    $('#clinics-content').html(response);
                    $('#clinics-tab').data('loaded', true);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading clinics:', error);
                    $('#clinics-content').html('<div class="alert alert-danger">Error loading clinics: ' + error + '</div>');
                }
            });
        }
    });
JS;

$this->registerJs($js);
?>