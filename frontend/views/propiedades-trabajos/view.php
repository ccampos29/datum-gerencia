<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\PropiedadesTrabajos */

$this->title = $model->tipoVehiculo->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Propiedades Trabajos', 'url' => ['index', 'idTrabajo' => $model->trabajo_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="propiedades-trabajos-view">

    <p>
        <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
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
            [
                'label' => 'Trabajo',
                'attribute' => 'trabajo.nombre'
            ],
            [
                'label' => 'Tipo Vehiculo',
                'attribute' => 'tipoVehiculo.descripcion'
            ],
            [
                'label' => 'Duracion (Minutos)',
                'attribute' => 'duracion'
            ],
            [
                'attribute' => 'costo_mano_obra',
                'value' => '$ '.number_format($model->costo_mano_obra, 0, '', '.'), 
            ],
            'cantidad_trabajo',
            [
                'label' => 'Repuesto',
                'attribute' => 'repuesto.nombre'
            ],
            'cantidad_repuesto',
        ],
    ]) ?>

</div>
