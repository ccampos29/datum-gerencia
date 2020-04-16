<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EtiquetasMantenimientos */

$this->title = 'Actualizar Etiquetas de Mantenimiento: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Etiquetas Mantenimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="etiquetas-mantenimientos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
