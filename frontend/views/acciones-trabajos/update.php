<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AccionesTrabajos */

$this->title = 'Actualizar Acciones Trabajos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Acciones Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="acciones-trabajos-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
