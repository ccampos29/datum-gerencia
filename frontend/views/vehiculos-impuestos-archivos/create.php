<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosImpuestosArchivos */

$this->title = 'Create Vehiculos Impuestos Archivos';
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Impuestos Archivos', 'url' => ['index', 'idv' => $_GET['idv'], 'idImpuesto' => $_GET['idImpuesto']]];



$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculos-impuestos-archivos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
