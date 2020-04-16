<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Mantenimientos */

$this->title = 'Actualizar Mantenimiento: ' . $model->vehiculo->placa.' - '.$model->fecha_hora_ejecucion;
$this->params['breadcrumbs'][] = ['label' => 'Mantenimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vehiculo->placa.' - '.$model->fecha_hora_ejecucion, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="mantenimientos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
