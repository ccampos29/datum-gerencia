<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\LineasMotores */

$this->title = 'Actualizar línea de motores: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lineas Motores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="lineas-motores-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
