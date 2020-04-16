<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CentrosCostos */

$this->title = 'Update Centros Costos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Centros Costos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="centros-costos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
