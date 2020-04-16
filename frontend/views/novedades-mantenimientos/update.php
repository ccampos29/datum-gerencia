<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\NovedadesMantenimientos */

$this->title = 'Actualizar Novedad de Mantenimiento: ' . $model->vehiculo->placa.' - '.$model->fecha_hora_reporte;
$this->params['breadcrumbs'][] = ['label' => 'Novedades Mantenimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vehiculo->placa.' - '.$model->fecha_hora_reporte, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="novedades-mantenimientos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
