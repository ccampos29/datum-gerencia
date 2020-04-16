<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\SemaforosVehiculos */

$this->title = 'Crear Semaforos Vehiculos';
$this->params['breadcrumbs'][] = ['label' => 'Semaforos Vehiculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semaforos-vehiculos-create">

    
    <?= $this->render('_form', [
        'model' => $model,
        'indicadores'=>$indicadores,
        'semaforos'=>$semaforos 
    ]) ?>

</div>
