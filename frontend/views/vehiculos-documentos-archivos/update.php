<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosDocumentosArchivos */

$this->title = 'Actualizar: ' . $model->tipoDocumento->nombre.'-'.$model->vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Documentos Archivos', 'url' => ['index','idv' => $_GET['idv'], 'idDocumento' => $_GET['idDocumento']]];
$this->params['breadcrumbs'][] = ['label' => $model->tipoDocumento->nombre.'-'.$model->vehiculo->placa, 'url' => ['view', 'id' => $model->id,'idv' => $_GET['idv'], 'idDocumento' => $_GET['idDocumento']]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="vehiculos-documentos-archivos-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
