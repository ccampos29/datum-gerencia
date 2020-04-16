<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosConductores */

$this->title = 'Asociar un conductor a un vehiculo';
$this->params['breadcrumbs'][] = ['label' => 'Asociar un conductor a un vehiculo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculos-conductores-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
