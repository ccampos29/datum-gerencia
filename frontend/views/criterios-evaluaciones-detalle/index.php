<?php

use frontend\models\CriteriosEvaluaciones;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CriteriosEvaluacionesDetalleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$tipo = CriteriosEvaluaciones::findOne($_GET['idCriterio'])->tipo;
$this->title = 'Configuracion del criterio: ' . $tipo;
$this->params['breadcrumbs'][] = ['label' => 'Criterios evaluacion', 'url' => ['criterios-evaluaciones/index', 'idCriterio' => $_GET['idCriterio']]];
$this->params['breadcrumbs'][] = $this->title;
$urlTiposCriterio = Url::to(['criterios-evaluaciones/tipos-criterios-list']);
$tipoCriterio = empty($searchModel->tipo_criterio_id) ? '' : $tipo;

$validate_show = ($tipo =="Editable");

?>
<div class="criterios-evaluaciones-detalle-index">

<!-- 
    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create', 'idCriterio' => $_GET['idCriterio']], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php $acciones =
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{view}{update}{delete}',
            'width' => '1%',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-eye-open"></span>',
                        Yii::$app->urlManager->createUrl(['criterios-evaluaciones-detalle/view', 'id' => $model->id, 'idCriterio' => $_GET['idCriterio']]),
                        [
                            'title' => 'Ver',
                        ]
                    );
                },
               'update' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        Yii::$app->urlManager->createUrl(['criterios-evaluaciones-detalle/update', 'id' => $model->id, 'idCriterio' => $_GET['idCriterio']]),
                        [
                            'title' => 'Actualizar',
                        ]
                    );
                }, 
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id, 'idCriterio' => $_GET['idCriterio']], [
                        'data' => [
                            'confirm' => 'Estas seguro de eliminar este item?',
                            'method' => 'post',
                        ],
                    ]);
                },
            ]
        ];
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'Tipo del Criterio' =>
            [
                'attribute' => 'tipo_criterio_id',
                'value' => function ($data) {
                    return $data->tipoCriterio->tipo;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un tipo de criterio ...'],
                    'initValueText' => $tipoCriterio,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlTiposCriterio,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'detalle',
            [
                'attribute' => 'rango',
                'visible' =>false
            ],
            [
                'attribute' => 'minimo',
                'visible' => $validate_show
            ],
            [
                'attribute' => 'maximo',
                'visible' => $validate_show
            ],
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',

            $acciones
        ],
    ]); ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['criterios-evaluaciones/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>

</div>