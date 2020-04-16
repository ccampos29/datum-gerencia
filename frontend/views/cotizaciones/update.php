<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cotizaciones */

$this->title = 'Actualizar Cotizaciones: ' . $model->proveedor->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index', 'idSolicitud' => $model->solicitud_id]];
$this->params['breadcrumbs'][] = ['label' => $model->proveedor->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="cotizaciones-update">

    <?= $this->render('_form', [
        'model' => $model,
        'idSolicitud' => $model->solicitud_id 
    ]) ?>

</div>
