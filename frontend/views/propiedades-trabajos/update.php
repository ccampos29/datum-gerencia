<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PropiedadesTrabajos */
$this->title = 'Actualizar Propiedad de  Trabajo: ' . $model->tipoVehiculo->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Propiedades Trabajos', 'url' => ['index', 'idTrabajo' => $model->trabajo_id]];
$this->params['breadcrumbs'][] = ['label' => $model->tipoVehiculo->descripcion, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';

?>
<div class="propiedades-trabajos-update">

    <?= $this->render('_form', [
        'model' => $model,
        'idTrabajo' => $model->trabajo_id
    ]) ?>

</div>
