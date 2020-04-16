<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesTrabajosTrabajos */

$this->title = 'Agregar Trabajos a la Orden';
$this->params['breadcrumbs'][] = ['label' => 'Trabajos', 'url' => ['index', 'idOrden' => $idOrden]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ordenes-trabajos-trabajos-create">

    <?= $this->render('_form', [
        'model' => $model,
        'idOrden' => $idOrden
    ]) ?>

</div>
