<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesTrabajosRepuestos */

$this->title = 'Crear Ordenes Trabajos Repuestos';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes Trabajos Repuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ordenes-trabajos-repuestos-create">

    <?= $this->render('_form', [
        'model' => $model,
        'idOrden' => $idOrden
    ]) ?>

</div>
