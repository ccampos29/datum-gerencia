<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RepuestosProveedores */

$this->title = 'Actualizar Repuesto Proveedor: ' . $model->repuesto->nombre. ' - '. $model->proveedor->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Repuestos Proveedores', 'url' => ['index', 'idRepuesto' => $model->repuesto_id]];
$this->params['breadcrumbs'][] = ['label' => $model->repuesto->nombre. ' - '. $model->proveedor->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="repuestos-proveedores-update">

    <?= $this->render('_form', [
        'model' => $model,
        'idRepuesto' => $model->repuesto_id,
    ]) ?>

</div>
