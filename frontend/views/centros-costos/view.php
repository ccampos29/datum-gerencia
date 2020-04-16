<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\CentrosCostos */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Centros Costos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="centros-costos-view">

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
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
            'id',
            'nombre',
            'codigo',

        ],
    ]) ?>
        <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>

</div>
