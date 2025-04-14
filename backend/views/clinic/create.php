<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Clinic $model */

$this->title = 'Create Clinic';
$this->params['breadcrumbs'][] = ['label' => 'Clinics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clinic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
