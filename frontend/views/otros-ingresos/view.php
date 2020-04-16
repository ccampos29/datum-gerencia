<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\OtrosIngresos */

$this->title = $model->vehiculo->placa.' - '.$model->tipoIngreso->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Otros Ingresos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="otros-ingresos-view">

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
                'attribute' => 'valor_ingreso',
                'value' => '$ '.number_format($model->valor_ingreso, 0, '', '.'), 
            ],
            'fecha',
            'observacion:ntext',
            ['label' => 'Placa del vehiculo',
            'attribute' => 'vehiculo.placa'],
            ['label' => 'Tipo del ingreso',
            'attribute' => 'tipoIngreso.nombre'],
            ['label' => 'Nombre del cliente',
            'attribute' => 'cliente.nombre'],
            
           
        ],
    ]) ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['otros-ingresos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
        
    </div>
</div>
