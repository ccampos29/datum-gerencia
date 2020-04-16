<?php

use frontend\models\MarcasMotores;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MotoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Motores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="motores-index">


    <p>
    <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Motor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'marca_motor_id',
                'value' => function ($data) {
                    return $data->marcaMotor->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar un motor ...'],
                    'initValueText' => empty($searchModel->marca_motor_id) ? '' : MarcasMotores::findOne($searchModel->marca_motor_id)->nombre,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => Url::to(['motores/motores-list']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'linea_motor_id',
                'value' => function ($data) {
                    return $data->lineaMotor->descripcion;
                }
            ],
            'codigo',
            'potencia',
            'torque',
            'rpm',
            'cilindraje',
           
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>