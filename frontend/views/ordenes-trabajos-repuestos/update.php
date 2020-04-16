<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesTrabajosRepuestos */

$this->title = 'Actualizar Orden de Trabajo: Repuesto - ' . $model->repuesto->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes Trabajos Repuestos', 'url' => ['index', 'idOrden' => $model->orden_trabajo_id]];
$this->params['breadcrumbs'][] = ['label' => 'Orden N° '.$model->ordenTrabajo->consecutivo. ' - '.$model->repuesto->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ordenes-trabajos-repuestos-update">

    <?= $this->render('_form', [
        'model' => $model,
        'idOrden' => $model->orden_trabajo_id
    ]) ?>

</div>
