<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\MarcasVehiculos */

$this->title = 'Actualizar Marcas: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Marcas Vehiculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="marcas-vehiculos-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
