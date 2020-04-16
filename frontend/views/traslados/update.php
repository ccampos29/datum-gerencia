<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Traslados */

$this->title = 'Actualizar Traslado: ' . $model->repuesto->nombre.' - '.$model->fecha_traslado;
$this->params['breadcrumbs'][] = ['label' => 'Traslados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->repuesto->nombre.' - '.$model->fecha_traslado, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="traslados-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
