<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ZonasCentrosCostos */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Zonas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="zonas-centros-costos-view">

    

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Actualizar', ['Actualizar', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Eliminar', ['Eliminar', 'id' => $model->id], [
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
            //'id',
            'nombre',
         
            'codigo',
            /*[
                'attribute' => 'creado_por',
                'value' => function ($data) {
                    return $data->creadoPor->username;
                }
            ],*/
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
        ],
    ]) ?>
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>

</div>
