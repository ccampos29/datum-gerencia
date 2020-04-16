<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\NovedadesMantenimientos */

$this->title = $model->vehiculo->placa . ' - ' . $model->fecha_hora_reporte;
$this->params['breadcrumbs'][] = ['label' => 'Novedades Mantenimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="novedades-mantenimientos-view">

    <p>
        <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Vehiculo',
                'attribute' => 'vehiculo.placa'
            ],
            'fecha_hora_reporte',
            [
                'label' => 'Reportada por',
                'attribute' => 'usuarioReporte.name'
            ],
            [
                'label' => 'Prioridad',
                'attribute' => 'prioridad_id',
                'value' => function ($data) {
                    switch ($data->prioridad_id) {
                        case 1:
                            return 'Bajo';
                            break;
                        case 2:
                            return 'Medio';
                            break;
                        case 3:
                            return 'Urgente';
                            break;
                    }
                },
                'format' => 'raw'
            ],
            'medicion',
            [
                'label' => 'Usuario Responsable',
                'attribute' => 'usuarioResponsable.name'
            ],
            [
                'label' => 'Trabajo',
                'attribute' => 'trabajo.nombre'
            ],
            'observacion',
            'fecha_solucion',
            'estado',
            'proviene_de',
            'checklist_id',
            'orden_trabajo_id'
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
        ],
    ]) ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['novedades-mantenimientos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>