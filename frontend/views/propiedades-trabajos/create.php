<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PropiedadesTrabajos */

$this->title = 'Crear Propiedad de Trabajo';
$this->params['breadcrumbs'][] = ['label' => 'Propiedades Trabajos', 'url' => ['index', 'idTrabajo' => $idTrabajo]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="propiedades-trabajos-create">

    <?= $this->render('_form', [
        'model' => $model,
        'idTrabajo' => $idTrabajo,
    ]) ?>

</div>
