<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Motores */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Motores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="motores-view">


    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
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
            ['attribute'=>'marca_motor_id',
            'value'=>function($e){
                return $e->marcaMotor->nombre;
            }],
            ['attribute'=>'linea_motor_id',
            'value'=>function($e){
                return $e->lineaMotor->descripcion;
            }],
            'codigo',
            'potencia',
            'torque',
            'rpm',
            'cilindraje',
            'observacion:ntext',
            ['attribute'=>'creado_por',
            'value'=>function($e){
                return $e->creadoPor->username;
            }],
            'creado_el',
        ],
    ]) ?>
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>

</div>
