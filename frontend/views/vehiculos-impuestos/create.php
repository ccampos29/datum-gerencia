<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosImpuestos */

$this->title = 'Crear';
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Impuestos', 'url' => ['index', 'idv' => $model->vehiculo_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculos-impuestos-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
