<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\LineasMarcas */

$this->title = 'Actualizar Líneas: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Lineas Marcas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="lineas-marcas-update">

   
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
