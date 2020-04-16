<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosDocumentosArchivos */

$this->title = 'Cargar un documento';
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Documentos Archivos', 'url' => ['index', 'idv'=>$_GET['idv'], 'idDocumento'=>$_GET['idDocumento']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculos-documentos-archivos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
