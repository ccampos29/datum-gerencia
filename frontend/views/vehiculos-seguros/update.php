<?php
use frontend\models\TiposSeguros;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosSeguros */
$test=TiposSeguros::findOne($model->tipo_seguro_id);
$this->title = 'Actualizar el seguro: ' . $model->tipoSeguro->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Seguros', 'url' => ['index', 'idv' => $model->vehiculo_id]];
$this->params['breadcrumbs'][] = ['label' => $test->nombre, 'url' => ['view', 'id' => $model->id, 'idv' => $model->vehiculo_id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="vehiculos-seguros-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
