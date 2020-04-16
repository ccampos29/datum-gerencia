<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\GruposVehiculos */

$this->title = 'Crear un Grupo para Vehiculos';
$this->params['breadcrumbs'][] = ['label' => 'Grupos Vehiculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-vehiculos-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
