<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\PeriodicidadesTrabajos */

$this->title = $model->vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Periodicidades Trabajos', 'url' => ['index', 'idTrabajo' => $model->trabajo_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="periodicidades-trabajos-view">

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
                'label' => 'Vehiculo',
                'attribute' => 'vehiculo.placa'
            ],
            [
                'label' => 'Trabajo',
                'attribute' => 'trabajo.nombre'
            ],
            'unidad_periodicidad',
            'trabajo_normal',
            'trabajo_bajo',
            'trabajo_severo',
            [
                'label' => 'Tipo Periodicidad',
                'attribute' => 'tipo_periodicidad',
                'value' => function ($data) {
                    switch ($data->tipo_periodicidad) {
                        case 1:
                            return 'Por Vehiculo';
                            break;
                        case 2:
                            return 'Por Linea de Vehiculo';
                            break;
                        case 3:
                            return 'Por tipo de Vehiculo y tipo de Motor';
                            break;
                        case 4:
                            return 'Por tipo de Vehiculo';
                            break;
                        case 5:
                            return 'Por tipo de Motor';
                            break;
                    }
                },
                'format' => 'raw',
            ]
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
        ],
    ]) ?>

        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['periodicidades-trabajos/index?idTrabajo=' . $model->trabajo_id]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>

</div>