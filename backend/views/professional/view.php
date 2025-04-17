<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Modal;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Professional $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Professionals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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

    <div class="row">
        <div class="col-md-12">
            <?= Html::button(
                'Bond Clinics',
                [
                    'id' => 'show-clinics-btn',
                    'class' => 'btn btn-primary'
                ]
            )
            ?>
        </div>
    </div>

    <?php 
        Modal::begin([
            'id' =>'clinics-modal',
            'title' => '<h4>Bond clinics</h4>',
            'size' => 'lg',
            'options' => [
                'tabindex' => false,
                'aria-labelledby' => 'clinics-modal-label',
            ],
            'bodyOptions' => [
                'id' => 'clinics-content',
            ],
        ]);

        Modal::end();
    ?>

    <?php

    $clinicsUrl = Url::to(['professional/clinics', 'id' => $model->id]);

    $js = <<<JS
    $('#show-clinics-btn').on('click', function() {
        $.ajax({
            url:'$clinicsUrl',
            type: 'GET',
            success: function(response){
                $('#clinics-content').html(response);
                var myModal = new bootstrap.Modal(document.getElementById('clinics-modal'));
                myModal.show();
        },
        error: function(xhr) {
            alert('Failed to load clinics.');
            console.error(xhr.responseText);
        }
    });
});

JS;

$this->registerJs($js);
?>