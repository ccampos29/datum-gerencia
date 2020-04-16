<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\SemaforosTrabajos */

$this->title = 'Actualizar Semaforos Trabajos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Semaforos Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="semaforos-trabajos-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
