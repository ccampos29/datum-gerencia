<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosSegurosArchivos */

$this->title = 'Cargar archivo: ';
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Seguros Archivos', 'url' => ['index', 'idv' => $_GET['idv'], 'idSeguro'=>$_GET['idSeguro']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculos-seguros-archivos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
