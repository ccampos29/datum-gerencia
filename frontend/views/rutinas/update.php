<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Rutinas */

$this->title = 'Actualizar Rutina: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Rutinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="rutinas-update">

    <?= $this->render('_form', [
        'model' => $model,
        'tieneRutinaTrabajo' => $tieneRutinaTrabajo
    ]) ?>

</div>
