<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Traslados */

$this->title = $model->repuesto->nombre.' - '.$model->fecha_traslado;
$this->params['breadcrumbs'][] = ['label' => 'Traslados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="traslados-view">

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
                'label' => 'Ubicacion Origen',
                'attribute' => 'ubicacionOrigen.nombre'
            ],
            [
                'label' => 'Repuesto',
                'attribute' => 'repuesto.nombre'
            ],
            [
                'label' => 'Ubicacion Destino',
                'attribute' => 'ubicacionDestino.nombre'
            ],
            'cantidad',
            'fecha_traslado',
            'observacion',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',
        ],
    ]) ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['traslados/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>