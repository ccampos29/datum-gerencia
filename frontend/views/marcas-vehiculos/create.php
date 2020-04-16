<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\MarcasVehiculos */

$this->title = 'Crear Marcas de Vehículos';
$this->params['breadcrumbs'][] = ['label' => 'Marcas Vehiculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marcas-vehiculos-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
