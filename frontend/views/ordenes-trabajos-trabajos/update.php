<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesTrabajosTrabajos */

$this->title = 'Actualizar Orden de Trabajo: Trabajo - ' . $model->trabajo->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes Trabajos Trabajos', 'url' => ['index', 'idOrden' => $model->orden_trabajo_id]];
$this->params['breadcrumbs'][] = ['label' => 'Orden N° '.$model->ordenTrabajo->consecutivo. ' - '.$model->trabajo->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="ordenes-trabajos-trabajos-update">

    <?= $this->render('_form', [
        'model' => $model,
        'idOrden' => $model->orden_trabajo_id
    ]) ?>

</div>
