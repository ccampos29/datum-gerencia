<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposImpuestos */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Impuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tipos-impuestos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este item?',
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
            'descripcion:ntext',
            'dias_alerta',
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
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>

</div>
