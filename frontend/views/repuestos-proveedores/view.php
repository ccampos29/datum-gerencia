<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\RepuestosProveedores */

$this->title = $model->repuesto->nombre . ' - ' . $model->proveedor->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Repuestos Proveedores', 'url' => ['index', 'idRepuesto' => $model->repuesto_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="repuestos-proveedores-view">

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
                'label' => 'Repuesto',
                'attribute' => 'repuesto.nombre'
            ],
            [
                'label' => 'Proveedor',
                'attribute' => 'proveedor.nombre'
            ],
            [
                'attribute' => 'valor',
                'value' => '$ ' . number_format($model->valor, 0, '', '.'),
            ],
            [
                'label' => 'Impuesto',
                'attribute' => 'impuesto.nombre'
            ],
            'descuento_repuesto',
            [
                'label' => 'Tipo Descuento',
                'attribute' => 'tipo_descuento',
                'value' => $model->tipo_descuento ? '%' : '$',
                'format' => 'raw'
            ],
            'codigo',
            'plazo_pago',
        ],
    ]) ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['repuestos-proveedores/index?idRepuesto=' . $model->repuesto_id]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>