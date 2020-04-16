<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosOtrosDocumentos */

$this->title = 'Actualizar el documento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Otros Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="vehiculos-otros-documentos-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
