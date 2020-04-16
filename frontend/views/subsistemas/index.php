<?php

use frontend\models\Sistemas;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SubSistemasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subsistemas';
$this->params['breadcrumbs'][] = $this->title;

$urlSistemas = Url::to(['sistemas/sistemas-list']);
$sistema = empty($searchModel->sistema_id) ? '' : Sistemas::findOne($searchModel->sistema_id)->nombre;
?>
<div class="subsistemas-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            [
                'attribute' => 'sistema_id',
                'value' => function ($data) {
                    return $data->sistema->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => 'Buscar por un sistema ...'],
                        'initValueText' => $sistema,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 1,
                            'language' => [
                                'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                            ],
                            'ajax' => [
                                'url' => $urlSistemas,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ],
                    'filterInputOptions' => ['placeholder' => ''],
            ],
            'codigo',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>