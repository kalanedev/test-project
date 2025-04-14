<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Professional $model */

$this->title = 'Create Professional';
$this->params['breadcrumbs'][] = ['label' => 'Professionals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="professional-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
