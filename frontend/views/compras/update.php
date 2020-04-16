<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Compras */

$this->title = 'Actualizar Compra con Numero Factura: ' . $model->numero_factura;
$this->params['breadcrumbs'][] = ['label' => 'Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Numero Factura: '.$model->numero_factura, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="compras-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
