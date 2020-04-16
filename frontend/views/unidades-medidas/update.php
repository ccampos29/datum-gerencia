<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\UnidadesMedidas */

$this->title = 'Actualizar Unidad de Medida: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Unidades Medidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="unidades-medidas-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
