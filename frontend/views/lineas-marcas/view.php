<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\LineasMarcas */

$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Lineas Marcas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lineas-marcas-view">

    

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'descripcion',
            'codigo',
            [
                'attribute' => 'marca_id',
                'value' => function ($data) {
                    return $data->marca->descripcion;
                }
            ],
            /*[
                'attribute' => 'creado_por',
                'value' => function ($data) {
                    return $data->creadoPor->username;
                }
            ],
            'creado_el',
            'actualizado_por',
            'actualizado_el',*/
        ],
    ]) ?>
        <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>

</div>
