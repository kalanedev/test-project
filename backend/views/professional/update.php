<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Professional $model */

$this->title = 'Update Professional: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Professionals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="professional-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
