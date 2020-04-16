<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\SemaforosVehiculos */

$this->title = 'Update Semaforos Vehiculos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Semaforos Vehiculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="semaforos-vehiculos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
