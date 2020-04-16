<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesTrabajosRepuestos */

$this->title = 'Orden N° ' . $model->ordenTrabajo->consecutivo . ' - ' . $model->repuesto->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes de Trabajos: Repuestos', 'url' => ['index', 'idOrden' => $model->orden_trabajo_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ordenes-trabajos-repuestos-view">

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
                'label' => 'Orden N°',
                'attribute' => 'ordenTrabajo.consecutivo'
            ],
            [
                'label' => 'Proveedor',
                'attribute' => 'proveedor.nombre'
            ],
            [
                'label' => 'Repuesto',
                'attribute' => 'repuesto.nombre'
            ],
            [
                'attribute' => 'costo_unitario',
                'value' => '$ '.number_format($model->costo_unitario, 0, '', '.'), 
            ],
            'cantidad'
            //'empresa_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
        ],
    ]) ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['ordenes-trabajos-repuestos/index?idOrden=' . $model->orden_trabajo_id]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>