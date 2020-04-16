<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesCompras */

$this->title = 'Actualizar Orden de Compra: ' . $model->fecha_hora_orden;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fecha_hora_orden, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="ordenes-compras-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
