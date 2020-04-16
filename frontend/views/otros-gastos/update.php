<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OtrosGastos */

$this->title = 'Actualizar: ' . $model->tipoGasto->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Otros Gastos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tipoGasto->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="otros-gastos-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
