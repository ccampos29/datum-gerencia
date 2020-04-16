<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\UbicacionesInsumos */

$this->title = 'Actualizar Ubicaciones Insumos: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Ubicaciones Insumos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="ubicaciones-insumos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
