<?php

use frontend\models\TiposVehiculos;
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

$this->title = 'Consulta de Personal';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="propiedades-trabajos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['costo-trabajos-tipo-vehiculo'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]);

    $columnas = [
        'serial' => ['class' => 'kartik\grid\SerialColumn'],
        'id' => [
            'attribute' => 'id_number',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        'nombres' => [
            'attribute' => 'name',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        'apellidos' => [
            'attribute' => 'surname',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        'nombre_usuario' => [
            'attribute' => 'username',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        'correo' => [
            'attribute' => 'email',
            'format' => 'email',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'label'=>'Ciudad',
            'value'=>function($data){
                return @$data->informacionAdicionalUsuarios->municipio->nombre;
            }
        ],
        [
            'label'=>'Dirección',
            'value'=>function($data){
                return @$data->informacionAdicionalUsuarios->direccion;
            }
        ],
        [
            'label'=>'Número Móvil',
            'value'=>function($data){
                return @$data->informacionAdicionalUsuarios->numero_movil;
            }
        ],
        [
            'label'=>'Número Fijo',
            'value'=>function($data){
                return @$data->informacionAdicionalUsuarios->numero_fijo_extension;
            }
        ],
        [
            'label'=>'Cuenta Bancaria',
            'value'=>function($data){
                return @$data->informacionAdicionalUsuarios->numero_cuenta_bancaria;
            }
        ],
        [
            'label'=>'Tipo de Cuenta',
            'value'=>function($data){
                return @$data->informacionAdicionalUsuarios->tipo_cuenta_bancaria;
            }
        ],
        [
            'label'=>'Banco',
            'value'=>function($data){
                return @$data->informacionAdicionalUsuarios->nombre_banco;
            }
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{ver_documentos}{informacion-adicional}',
            'header' => '',
            'width' => '1%',
            'buttons' => [
                'ver_documentos' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-folder-open"></span>',
                        Yii::$app->urlManager->createUrl(['user/ver-documentos', 'iUs' => $model->id]),
                        [
                            'title' => 'Ver documentos',
                        ]
                    );
                },
            ]
        ]
    ];

    ?>

    <div class="container-fluid col-sm-12">
        <div class="row" style="margin-top:40px;">
            <div class="col-sm-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                    'columns' => $columnas,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> ' . $this->title . ' </h3>',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'rowOptions' => function ($model) {
                        if ($model->estado == \common\models\User::ESTADO_INACTIVO) {
                            return ['class' => 'danger'];
                        } elseif ($model->estado == \common\models\User::ESTADO_ACTIVO) {
                            return ['class' => 'success'];
                        } else {
                            return ['class' => 'warning'];
                        }
                    },
                    'bootstrap' => true,
                    'striped' => false,
                    'responsive' => true,
                    'hover' => true,
                    'condensed' => true,
                    'floatHeader' => false,
                    'resizableColumns' => true,
                    'responsiveWrap' => false,
                    'perfectScrollbar' => true,
                    'export' => [
                        'label' => 'Descargar',
                    ],

                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta Combustible Proveedor',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>