<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\InventariosAjustes */

$this->title = 'Actualizar el Ajuste: ' . $model->repuesto->nombre.' - '.$model->concepto->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Inventarios Ajustes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->repuesto->nombre.' - '.$model->concepto->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="inventarios-ajustes-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
