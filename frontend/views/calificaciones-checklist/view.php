<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\CalificacionesChecklist */

$this->title = "Criterio numero".$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Calificaciones Checklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="calificaciones-checklist-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>Actualizar', ['update', 'id' => $model->id, 'idChecklist' => $model->id, 'idv'=>$model->vehiculo_id, 'idTipo'=>$model->tipo_checklist_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>Eliminar', ['delete', 'id' => $model->id, 'idChecklist' => $model->id, 'idv'=>$model->vehiculo_id, 'idTipo'=>$model->tipo_checklist_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            ['label' => 'Detalle de la calificacion',
            'attribute' => 'detalle.detalle'],
            ['label' => 'Novedad',
            'attribute' => 'novedad.nombre'],
            ['label' => 'Grupo de la novedad',
            'attribute' => 'grupoNovedad.nombre'],
            ['label' => 'Numero del checklist',
            'attribute' => 'checklist_id'],
            ['label' => 'Tipo del checklist',
            'attribute' => 'tipoChecklist.nombre'],
            ['label' => 'Placa del vehiculo',
            'attribute' => 'vehiculo.placa'],
            ['label' => 'Criterio de la calificacion',
            'attribute' => 'criterioCalificacion.nombre'],
            
        ],
    ]) ?>

</div>
