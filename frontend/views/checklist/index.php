<?php

use frontend\models\Vehiculos;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ChecklistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Checklists';
$this->params['breadcrumbs'][] = $this->title;
$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;

?>
<div class="checklist-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php 

    $calificacionChecklist = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{calificacion}',
        'width' => '1%',
        'buttons' => [
            'calificacion' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-check"></span>',
                        Yii::$app->urlManager->createUrl(['checklist/calification','id' => $model->id]),
                        [
                            'title' => 'Calificacion del Checklist',
                        ]
                    );
            },
        ]
    ];
?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            //'id',
            'Fecha de realizacion del checklist'=>[
                'attribute' => 'fecha_checklist',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_checklist',
                    'presetDropdown' => false,
                    'convertFormat' => false,
                    'options' => [
                        'class' => 'form-control range-value',
                    ],
                    'pluginOptions' => [
                        'separator' => ' - ',
                        'format' => 'YYYY-MM-DD',
                        'locale' => [
                            'format' => 'YYYY-MM-DD',
                            'cancelLabel' => 'Limpiar'
                        ],
                    ],
                    'pluginEvents' => [
                        "apply.daterangepicker" => "function() { apply_filter('fecha_checklist') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            'Fecha del siguiente checklist'=>[
                'attribute' => 'fecha_siguente',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_siguente',
                    'presetDropdown' => false,
                    'convertFormat' => false,
                    'options' => [
                        'class' => 'form-control range-value',
                    ],
                    'pluginOptions' => [
                        'separator' => ' - ',
                        'format' => 'YYYY-MM-DD',
                        'locale' => [
                            'format' => 'YYYY-MM-DD',
                            'cancelLabel' => 'Limpiar'
                        ],
                    ],
                    'pluginEvents' => [
                        "apply.daterangepicker" => "function() { apply_filter('fecha_siguente') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            'hora_medicion',
            [
                'attribute' => 'medicion_siguente',
                'value' => function ($data) {
                    return number_format($data->medicion_siguente, 0, '', '.');
                },
            ],
            //'observacion:ntext',
            'Placa del vehiculo' => 
            [
                'attribute' => 'vehiculo_id',
                'headerOptions' => ['style' => 'width:15%'],
                'value' => function ($data) {
                    return $data->vehiculo->placa;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $vehiculo,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlVehiculos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
                        //'tipo_checklist_id',
            //'medicion_actual',
            //'usuario_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            ['class' => 'yii\grid\ActionColumn'],
            $calificacionChecklist
            
        ],
    ]); ?>


</div>
