<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Mantenimientos */

$this->title = $model->vehiculo->placa.' - '.$model->fecha_hora_ejecucion;
$this->params['breadcrumbs'][] = ['label' => 'Mantenimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mantenimientos-view">


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
            'descripcion',
            'fecha_hora_ejecucion',
            'medicion',
            'medicion_ejecucion',
            'duracion',
            ['label' => 'Vehiculo',
            'attribute' => 'vehiculo.placa'],
            ['label' => 'Trabajo',
            'attribute' => 'trabajo.nombre'],
            ['label' => 'Tipo Mantenimiento',
            'attribute' => 'tipoMantenimiento.nombre'],
            'estado',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
        ],
    ]) ?>

<div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['mantenimientos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>
