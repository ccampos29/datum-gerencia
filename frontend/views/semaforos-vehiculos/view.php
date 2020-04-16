<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\SemaforosVehiculos */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Semaforos Vehiculos', 'url' => ['index', 'idv' => $model->vehiculo_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="semaforos-vehiculos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id, 'idv' => $model->vehiculo_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id, 'idv' => $model->vehiculo_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro que desea eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'indicador',
            'desde',
            'hasta',
        ],
    ]) ?>

</div>
