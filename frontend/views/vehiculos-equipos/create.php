<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosEquipos */

$this->title = 'Vincular equipos';
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos equipos', 'url' => ['index', 'idv'=>$_GET['idv']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculos-equipos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
