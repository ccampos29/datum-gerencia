<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\InventariosAjustes */

$this->title = $model->repuesto->nombre.' - '.$model->concepto->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Inventarios Ajustes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inventarios-ajustes-view">

    <p>
        <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>  Eliminar', ['delete', 'id' => $model->id], [
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
            ['label' => 'Repuesto',
            'attribute' => 'repuesto.nombre'],
            ['label' => 'Ubicacion',
            'attribute' => 'ubicacionInventario.nombre'],
            'cantidad_repuesto',
            ['label' => 'Concepto',
            'attribute' => 'concepto.nombre'],
            'observaciones:ntext',
            'fecha_ajuste',
            ['label' => 'Registrado a',
            'attribute' => 'usuario.name'],
            //'empresa_id',
            [
                'attribute' => 'saldo',
                'value' => '$ '.number_format($model->saldo, 0, '', '.'), 
            ],
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
        ],
    ]) ?>

<div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['inventarios-ajustes/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>

</div>
