<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\DocumentosProveedores */

$this->title = 'Actualizar Documentos de Proveedores: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Documentos Proveedores', 'url' =>  ['index',"id"=>$_GET['id']]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documentos-proveedores-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
