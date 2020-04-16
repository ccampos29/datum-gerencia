<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiemposMuertos */

$this->title = 'Actualizar tiempos muertos: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Tiempos Muertos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tiempos-muertos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
