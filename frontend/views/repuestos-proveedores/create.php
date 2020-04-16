<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RepuestosProveedores */

$this->title = 'Crear Repuesto por Proveedor';
$this->params['breadcrumbs'][] = ['label' => 'Repuestos Proveedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repuestos-proveedores-create">

    <?= $this->render('_form', [
        'model' => $model,
        'idRepuesto' => $idRepuesto
    ]) ?>

</div>
