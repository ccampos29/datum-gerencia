<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\TiposImpuestos;
use frontend\models\Vehiculos;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosImpuestos */
$nombreImpuesto = TiposImpuestos::findOne($model->tipo_impuesto_id);
$nombreVehiculo = Vehiculos::findOne($model->vehiculo_id);
$this->title = $nombreImpuesto->nombre. " - " .$nombreVehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Impuestos', 'url' => ['index', 'idv' => $model->vehiculo_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehiculos-impuestos-view">

    
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
            
            [
                'attribute' => 'valor_impuesto',
                'value' => '$ '.number_format($model->valor_impuesto, 0, '', '.'), 
            ],
            'fecha_expedicion:date',
            'fecha_expiracion:date',
            ['label' => 'Placa del vehiculo',
            'attribute' => 'vehiculo.placa'],
            ['label' => 'Tipo de impuesto',
            'attribute' => 'tipoImpuesto.nombre'],
            ['label' => 'Centro de costos',
            'attribute' => 'centroCosto.nombre'],
            'descripcion:ntext',
            
        ],
    ]) ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-impuestos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>
</div>
