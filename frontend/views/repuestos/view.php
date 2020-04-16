<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Repuestos */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Repuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="repuestos-view">

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
            //'id',
            'nombre',
            'fabricante',
            [
                'attribute' => 'precio',
                'value' => '$ '.number_format($model->precio, 0, '', '.'), 
            ],
            'observacion',
            'codigo',
            [
                'label' => 'Estado',
                'attribute' => 'estado',
                'value' => $model->estado ? '<div class="label label-success">Activo</div>' : '<div class="label label-danger">Inactivo</div>',
                'format' => 'raw'
            ],
            [
                'label' => 'Inventariable',
                'attribute' => 'inventariable',
                'value' => $model->inventariable ? 'Si' : 'No',
                'format' => 'raw'
            ],
            [
                'label' => 'Unidad de Medida',
                'attribute' => 'unidadMedida.nombre'
            ],
            [
                'attribute' => 'grupo_repuesto_id',
                'value' => function ($data) {
                    if ($data->grupo_repuesto_id === null) {
                        return 'Sin grupo repuesto';
                    } else {
                        return $data->grupoRepuesto->nombre;
                    }
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'sistema_id',
                'value' => function ($data) {
                    if ($data->sistema_id === null) {
                        return 'Sin sistema';
                    } else {
                        return $data->sistema->nombre;
                    }
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'subsistema_id',
                'value' => function ($data) {
                    if ($data->subsistema_id === null) {
                        return 'Sin subsistema';
                    } else {
                        return $data->subsistema->nombre;
                    }
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'cuenta_contable_id',
                'value' => function ($data) {
                    if ($data->cuenta_contable_id === null) {
                        return 'Sin cuenta contable';
                    } else {
                        return $data->cuentaContable->nombre;
                    }
                },
                'format' => 'raw',
            ],
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
        ],
    ]) ?>
    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['repuestos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>