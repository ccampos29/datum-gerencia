<?php

use frontend\models\Vehiculos;
use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\MantenimientosSearch */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Documentos agrupados por Vehiculo';

?>
<style>
span.vencido {
    background: red;
    padding: 0 10px;
    color: white;
    border-radius: 10px;
    margin-left: 20px;
}</style>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="vehiculos-seguros-search vehiculos-impuestos-search vehiculos-otros-documentos-search">

<?php $columnaDocumentoSeguros = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{documento}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'documento' => function ($url, $modelSeguros) {
                return Html::a(
                    '<span class="glyphicon glyphicon-folder-open"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos-seguros-archivos', 'idv' => $modelSeguros->vehiculo_id, 'idSeguro'=>$modelSeguros->tipo_seguro_id]),
                    [
                        'title' => 'Ver Seguros',
                    ]
                );
            },
        ]
    ];
    $columnaDocumentoImpuestos = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{documento}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'documento' => function ($url, $modelImpuestos) {
                return Html::a(
                    '<span class="glyphicon glyphicon-folder-open"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos-impuestos-archivos', 'idv' => $modelImpuestos->vehiculo_id, 'idImpuesto'=>$modelImpuestos->tipo_impuesto_id]),
                    [
                        'title' => 'Ver Impuestos',
                    ]
                );
            },
        ]
    ];

    $columnaDocumentoDocumentos = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{documento}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'documento' => function ($url, $modelDocumentos) {
                return Html::a(
                    '<span class="glyphicon glyphicon-folder-open"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos-documentos-archivos', 'idv' => $modelDocumentos->vehiculo_id, 'idDocumento'=>$modelDocumentos->tipo_documento_id]),
                    [
                        'title' => 'Ver Impuestos',
                    ]
                );
            },
        ]
    ];
    ?>

    <?php $form = ActiveForm::begin([
        'action' => ['gestion-documental'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]);?>

    <div class="container-fluid col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-car" aria-hidden="true"></i> Vehiculo
                </label>
                <?= $form->field($modelSeguros, 'vehiculo_id')->widget(Select2::classname(), [
                    'data' => !empty($modelSeguros->vehiculo_id) ? [$modelSeguros->vehiculo_id => Vehiculos::findOne($modelSeguros->vehiculo_id)->placa] : [],
                    'options' => ['id' => 'select-vehiculo'],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un vehiculo',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false)
                ?>
                <?= $form->field($modelImpuestos, 'vehiculo_id')->textInput(['class' => 'hidden', 'id' => 'impuestos'])->label(false);?>
                <?= $form->field($modelDocumentos, 'vehiculo_id')->textInput(['class' => 'hidden', 'id' => 'documentos'])->label(false);?>
            </div>
            <div class="col-sm-6">
                    
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i>  Buscar', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('<i class="fa fa-refresh" aria-hidden="true"></i> Limpiar', ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
        <div class="row" style="margin-top:40px;">
            <div class="col-sm-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProviderSeguros,
                    //'filterModel' => $searchModel,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-save-file"></i> Informe de Seguros</h3>',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'tipo_seguro_id',
                            'value' => function ($data) {
                                return $data->tipoSeguro->nombre;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'vehiculo_id',
                            'value' => function ($data) {
                                return $data->vehiculo->placa;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'proveedor_id',
                            'value' => function ($data) {
                                return $data->proveedor->nombre;
                            },
                            'format' => 'raw',
                        ],
                        'numero_poliza',
                        [
                            'attribute' => 'valor_seguro',
                            'value' => function ($data) {
                                return '$ '. number_format($data->valor_seguro, 0, '', '.');
                            },
                            'format' => 'raw', 
                        ],
                        'fecha_vigencia',
                        'fecha_expedicion',
                        'fecha_expiracion',
                        ['label'=>'Vencimiento',
                        'format'=>'raw',
                        'value'=>function($data){
                            $OldDate = strtotime($data->fecha_expiracion);
                            $NewDate = date('M j, Y', $OldDate);
                            $diff = date_diff(date_create($NewDate),date_create(date("M j, Y")));
                            $dias = $diff->d;
                            if($dias>0){
                                return '<span class="vencido"> -'.$diff->d.'</span>';
                            }
                            return 0;
                        }],
                        [
                            'attribute' => 'centro_costo_id',
                            'value' => function ($data) {
                                return $data->centroCosto->nombre;
                            },
                            'format' => 'raw',
                        ],
                        $columnaDocumentoSeguros,
                        [
                            'attribute' => 'id', 'visible' => false
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{ver_seguros}',
                            'header' => "",
                            'width' => '1%',
                            'buttons' => [
                                'ver_seguros' => function ($url, $model) {
                                        return Html::a(
                                            '<span class="glyphicon glyphicon-folder-open"></span>',
                                            Yii::$app->urlManager->createUrl(['vehiculos-seguros-archivos', 'idv' => $model->vehiculo_id, 'idSeguro'=>$model->tipo_seguro_id,'visible'=>true]),
                                            [
                                                'title' => 'Ver seguros',
                                            ]
                                        );
                                },
                            ]
                        ]
                    ],

                    'export' => [
                        'label' => 'Descargar',
                    ],

                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Seguros Vehiculo',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>
        <div class="row" style="margin-top:40px;">
            <div class="col-sm-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProviderImpuestos,
                    //'filterModel' => $searchModel,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-save-file"></i> Informe de Impuestos</h3>',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'tipo_impuesto_id',
                            'value' => function ($data) {
                                return $data->tipoImpuesto->nombre;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'vehiculo_id',
                            'value' => function ($data) {
                                return $data->vehiculo->placa;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'valor_impuesto',
                            'value' => function ($data) {
                                return '$ '. number_format($data->valor_impuesto, 0, '', '.');
                            },
                            'format' => 'raw', 
                        ],
                        'fecha_expedicion',
                        'fecha_expiracion',
                        ['label'=>'Vencimiento',
                        'format'=>'raw',
                        'value'=>function($data){
                            $OldDate = strtotime($data->fecha_expiracion);
                            $NewDate = date('M j, Y', $OldDate);
                            $diff = date_diff(date_create($NewDate),date_create(date("M j, Y")));
                            $dias = $diff->d;
                            if($dias>0){
                                return '<span class="vencido"> -'.$diff->d.'</span>';
                            }
                            return 0;
                        }],
                        [
                            'attribute' => 'centro_costo_id',
                            'value' => function ($data) {
                                return $data->centroCosto->nombre;
                            },
                            'format' => 'raw',
                        ],
                        'descripcion:ntext',
                        $columnaDocumentoImpuestos,
                        [
                            'attribute' => 'id', 'visible' => false
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{cargar_archivos}',
                            'header' => "",
                            'width' => '1%',
                            'buttons' => [
                                'cargar_archivos' => function ($url, $model) {
                                        return Html::a(
                                            '<span class="glyphicon glyphicon-folder-open"></span>',
                                            Yii::$app->urlManager->createUrl(['vehiculos-impuestos-archivos', 'idv' => $model->vehiculo_id, 'idImpuesto'=>$model->tipo_impuesto_id,'visible'=>true]),
                                            [
                                                'title' => 'Cargar archivos',
                                            ]
                                        );
                                },
                            ]
                        ]
                    ],

                    'export' => [
                        'label' => 'Descargar',
                    ],

                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Impuestos Vehiculo',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>
        <div class="row" style="margin-top:40px;">
            <div class="col-sm-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProviderDocumentos,
                    //'filterModel' => $searchModel,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-save-file"></i> Informe de Documentos</h3>',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'tipo_documento_id',
                            'value' => function ($data) {
                                return $data->tipoDocumento->nombre;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'vehiculo_id',
                            'value' => function ($data) {
                                return $data->vehiculo->placa;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'proveedor_id',
                            'value' => function ($data) {
                                return $data->proveedor->nombre;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'valor_unitario',
                            'value' => function ($data) {
                                return '$ '. number_format($data->valor_unitario, 0, '', '.');
                            },
                            'format' => 'raw', 
                        ],
                        'fecha_expedicion',
                        'fecha_expiracion',
                        ['label'=>'Vencimiento',
                        'format'=>'raw',
                        'value'=>function($data){
                            $OldDate = strtotime($data->fecha_expiracion);
                            $NewDate = date('M j, Y', $OldDate);
                            $diff = date_diff(date_create($NewDate),date_create(date("M j, Y")));
                            $dias = $diff->d;
                            if($dias>0){
                                return '<span class="vencido"> -'.$diff->d.'</span>';
                            }
                            return 0;
                        }],
                        [
                            'attribute' => 'centro_costo_id',
                            'value' => function ($data) {
                                return $data->centroCosto->nombre;
                            },
                            'format' => 'raw',
                        ],
                        'descripcion:ntext',
                        $columnaDocumentoDocumentos,
                        [
                            'attribute' => 'id', 'visible' => false
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{cargar_archivos}',
                            'header' => "",
                            'width' => '1%',
                            'buttons' => [
                                'cargar_archivos' => function ($url, $model) {
                                        return Html::a(
                                            '<span class="glyphicon glyphicon-folder-open"></span>',
                                            Yii::$app->urlManager->createUrl(['vehiculos-documentos-archivos', 'idv' => $model->vehiculo_id, 'idDocumento'=>$model->tipo_documento_id,'visible'=>true]),
                                            [
                                                'title' => 'Cargar archivos',
                                            ]
                                        );
                                },
                            ]
                        ]
                    ],

                    'export' => [
                        'label' => 'Descargar',
                    ],

                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Documentos Vehiculo',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end();
     $this->registerJsFile(
        '@web/js/consultasGestionDocumental.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    ); ?>
</div>
<?php Pjax::end(); ?>