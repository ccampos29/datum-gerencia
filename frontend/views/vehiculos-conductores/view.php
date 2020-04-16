<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosConductores */

$this->title = $model->conductor->name.' '.$model->conductor->surname;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Conductores', 'url' => ['index', 'idv' => $model->vehiculo->id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehiculos-conductores-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id, 'idv' => $model->vehiculo->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id, 'idv' => $model->vehiculo->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            ['label' => 'Placa del vehiculo',
            'attribute' => 'vehiculo.placa'],
            ['label' => 'Placa del vehiculo',
            'attribute' => 'conductor.name'],
            'fecha_desde',
            'fecha_hasta',
            'dias_alerta',
            [
                'attribute' => 'principal',
                'label'=>'Es principal',
                'value' => function ($data) {
                    if($data->principal == 1){
                        return 'Principal';
                    }else{
                        return 'No es principal';
                    }
                    
                }
            ],
            [
                'attribute' => 'estado',
                'label'=>'Estado',
                'value' => function ($data) {
                    if($data->estado == 1){
                        return 'Activo';
                    }else{
                        return 'Inactivo';
                    }
                }
            ],
        ],
    ]) ?>
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-conductores/index', 'idv' => $model->vehiculo->id]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    
</div>
