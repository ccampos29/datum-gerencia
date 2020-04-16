<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PeriodicidadesRutinas */

$this->title = 'Crear Periodicidad de Rutina';
$this->params['breadcrumbs'][] = ['label' => 'Periodicidades Rutinas', 'url' => ['index', 'idRutina' => $idRutina]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periodicidades-rutinas-create">

    <?= $this->render('_form', [
        'model' => $model,
        'idRutina' => $idRutina,
    ]) ?>

</div>
