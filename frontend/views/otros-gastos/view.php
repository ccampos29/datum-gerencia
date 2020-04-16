<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\OtrosGastos */

$this->title =$model->vehiculo->placa.' - '.$model->tipoGasto->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Otros Gastos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

if ($model->tipo_descuento=='$'){ 
    $var= [
        'attribute' => 'cantidad_descuento',
        'value' => '$'.number_format($model->cantidad_descuento, 0, '', '.'), 
    ];
}else{
    $var= [
        'attribute' => 'cantidad_descuento',
        'value' => number_format($model->cantidad_descuento, 0, '', '.').'%', 
    ];
}
?>
<div class="otros-gastos-view">

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
            'factura',
            'codigo_interno',
            'fecha',
            [
                'attribute' => 'valor_unitario',
                'value' => '$ '.number_format($model->valor_unitario, 0, '', '.'), 
            ],
            'cantidad_unitaria',
            'observacion:ntext',
            'tipo_descuento',
            $var,
            ['label' => 'Placa del vehiculo',
            'attribute' => 'vehiculo.placa'],
            ['label' => 'Tipo del gasto',
            'attribute' => 'tipoGasto.nombre'],
            ['label' => 'Tipo del impuesto',
            'attribute' => 'tipoImpuesto.nombre'],
            //'tipo_impuesto_id',
            //'usuario_id',
            //'proveedor_id'
            ['label' => 'Usuario',
            'attribute' => 'user.name'],
            ['label' => 'Proveedores',
            'attribute' => 'proveedor.nombre'],
        ],       
    ]) ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['otros-gastos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>
</div>
