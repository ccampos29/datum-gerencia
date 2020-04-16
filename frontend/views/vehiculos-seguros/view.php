<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Vehiculos;
use frontend\models\TiposSeguros;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosSeguros */
$placaVehiculo= Vehiculos::findOne($model->vehiculo_id);
$nombreSeguro= TiposSeguros::findOne($model->tipo_seguro_id);
$this->title = $nombreSeguro->nombre." - ".$placaVehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Seguros', 'url' => ['index', 'idv' => $model->vehiculo_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehiculos-seguros-view">

    

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Esta seguro de eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'numero_poliza',
            [
                'attribute' => 'valor_seguro',
                'value' => '$ '.number_format($model->valor_seguro, 0, '', '.'), 
            ],
            
            'fecha_expedicion:date',
            'fecha_expiracion:date',
            ['label' => 'Placa del vehiculo',
            'attribute' => 'vehiculo.placa'],
            ['label' => 'Proveedores',
            'attribute' => 'proveedor.nombre'],
            ['label' => 'Tipo del seguro',
            'attribute' => 'tipoSeguro.nombre'],
            ['label' => 'Centro de costos',
            'attribute' => 'centroCosto.nombre'],
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
        ],
    ]) ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-seguros/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>
</div>
