<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\Mediciones */

$this->title = $model->vehiculo->placa.' - '.$model->fecha_medicion;
$this->params['breadcrumbs'][] = ['label' => 'Mediciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mediciones-view">

   <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Esta seguro de eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fecha_medicion',
            'hora_medicion',
            [
                'attribute' => 'valor_medicion',
                'value' => number_format($model->valor_medicion, 0, '', '.'), 
            ],
            'estado_vehiculo',
            'tipo_medicion',
            ['label' => 'Placa del vehiculo',
            'attribute' => 'vehiculo.placa'],
            'proviene_de',
            //'usuario_id',
            ['label' => 'Usuario',
            'attribute' => 'usuario.name'],
            'observacion:ntext',
            
        ],
    ]) ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['mediciones/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>

    </div>
</div>
