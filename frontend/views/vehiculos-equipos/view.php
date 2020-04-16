<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosEquipos */

$this->title = "Equipos del: ".$model->vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos equipos', 'url' => ['index', 'idv'=>$model->vehiculo->id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehiculos-equipos-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id, 'idv'=>$_GET['idv']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id, 'idv'=>$_GET['idv']], [
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
            
            
            [
                'label'=>'Placa del vehiculo',
                'attribute'=>'vehiculo.placa'
            ],
            [
                'label'=>'Placa del vehiculo',
                'attribute'=>'vehiculoVinculado.placa'
            ],
            'fecha_desde',
            'fecha_hasta',
            [
                'attribute' => 'estado',
                'value' => function ($data) {
                    switch ($data->estado) {
                        case 1:
                            return '<label class="label label-success">Activo</label>';
                            break;
                        case 0:
                            return '<label class="label label-warning">Inactivo</label>';
                            break;
                    }
                },
                'format' => 'raw',
            ],
            
        ],
    ]) ?>
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-equipos/index', 'idv'=>$model->vehiculo->id]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    
</div>
