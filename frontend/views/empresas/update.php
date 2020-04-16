<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Empresas */

$this->title = 'Actualizar empresa: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="empresas-update">


    <?= $this->render('_form', [
        'model' => $model,
        'modelUsuario' => $modelUsuario
    ]) ?>

</div>
