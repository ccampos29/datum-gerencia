<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PeriodicidadesTrabajos */

$this->title = 'Crear Periodicidad de Trabajo';
$this->params['breadcrumbs'][] = ['label' => 'Periodicidades Trabajos', 'url' => ['index', 'idTrabajo' => $idTrabajo]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periodicidades-trabajos-create">

    <?= $this->render('_form', [
        'model' => $model,
        'idTrabajo' => $idTrabajo,
    ]) ?>

</div>
