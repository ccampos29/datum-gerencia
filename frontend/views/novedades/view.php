<?php

use frontend\models\NovedadesTiposChecklist;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Novedades */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Novedades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="novedades-view">


    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro que deseas eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            [
                'attribute' => 'grupo_novedad_id',
                'value' => function ($data) {
                    return $data->grupoNovedad->nombre;
                }
            ],
            [
                'attribute' => 'criterio_evaluacion_id',
                'value' => function ($data) {
                    return $data->criterioEvaluacion->nombre;
                }
            ],
            [
                'attribute'=>'tipo_checklist_id',
                'label'=>'Tipos De Checklist Seleccionados',
                'value'=>function($data){
                    $tips = "";
                    $inf = NovedadesTiposChecklist::find()->where(['novedad_id'=>$data->id])->all();
                    foreach($inf as $tip)
                      $tips .= $tip->tipoChecklist->nombre.',';
                    return $tips;
                }
            ],
            'observacion:ntext',
        ],
    ]) ?>

    <h3>Detalle Criterios Checklist</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Calificación</th>
                <th>Trabajo</th>
                <th>Prioridad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($novedades_carga as $novedad) : ?>
                <tr>
                    <th><?= @$novedad->calificacion0->estado ?></th>
                    <th><?= @$novedad->trabajo->nombre ?></th>
                    <th><?= @$novedad->prioridad ?></th>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>

</div>