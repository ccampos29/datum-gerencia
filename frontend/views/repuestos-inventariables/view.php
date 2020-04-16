<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\RepuestosInventariables */

$this->title = $model->repuesto->nombre . ' - ' . $model->ubicacion->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Repuestos Inventariables', 'url' => ['index', 'idRepuesto' => $model->repuesto_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="repuestos-inventariables-view">

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
                'label' => 'Ubicacion',
                'attribute' => 'ubicacion.nombre'
            ],
            'cantidad',
            [
                'attribute' => 'valor_unitario',
                'value' => '$ ' . number_format($model->valor_unitario, 0, '', '.'),
            ],
            'cantidad_minima',
            'cantidad_maxima',
        ],
    ]) ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['repuestos-inventariables/index?idRepuesto=' . $model->repuesto_id]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>