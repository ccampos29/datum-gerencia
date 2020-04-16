<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Trabajos */

$this->title = 'Actualizar Trabajo: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="trabajos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
