<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Vehiculos;
use frontend\models\TiposOtrosDocumentos;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosOtrosDocumentos */
$vehiculo = Vehiculos::findOne($model->vehiculo_id);
$documento = TiposOtrosDocumentos::findOne($model->tipo_documento_id);

$this->title = $documento->nombre. " - " .$vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Otros Documentos', 'url' => ['index', 'idv' => $model->vehiculo_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehiculos-otros-documentos-view">


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
            //'codigo',
            [
                'attribute' => 'valor_unitario',
                'value' => '$ '.number_format($model->valor_unitario, 0, '', '.'), 
            ],
            'fecha_expedicion:date',
            'fecha_expiracion:date',
            ['label' => 'Placa del vehiculo',
            'attribute' => 'vehiculo.placa'],
            ['label' => 'Tipo de documento',
            'attribute' => 'tipoDocumento.nombre'],
            //'tipo_documento_id',
            ['label' => 'Proveedores',
            'attribute' => 'proveedor.nombre'],
            ['label' => 'Centro de costos',
            'attribute' => 'centroCosto.nombre'],
            'descripcion:ntext',
            
        ],
    ]) ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-documentos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>
</div>
