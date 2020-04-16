<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RepuestosInventariables */

$this->title = 'Actualizar Repuesto Inventariable: ' . $model->repuesto->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Repuestos Inventariables', 'url' => ['index', 'idRepuesto' => $model->repuesto_id]];
$this->params['breadcrumbs'][] = ['label' => $model->repuesto->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="repuestos-inventariables-update">

    <?= $this->render('_form', [
        'model' => $model,
        'idRepuesto' => $model->repuesto_id,
    ]) ?>

</div>
