<?php

use frontend\models\Municipios;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ClientesSucursalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes Sucursales';
$this->params['breadcrumbs'][] = $this->title;
$urlCiudades = Url::to(['municipios/ciudades-list']);
$ciudad = empty($searchModel->municipio_id) ? '' : Municipios::findOne($searchModel->municipio_id)->nombre;

//$urlMunicipios = Url::to(['municipios/municipios-list']);
//$municipio = empty($searchModel->marca_vehiculo_id) ? '' : MarcasVehiculos::findOne($searchModel->marca_vehiculo_id)->descripcion;

?>
<div class="clientes-sucursales-index">


    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            //'codigo',
            'direccion',
            'telefono_fijo',
            'telefono_movil',
            //'contacto:ntext',
            //'pais_id',
            //'departamento_id',
            'Tipo de servicio' => [
                'attribute' => 'municipio_id',
                'value' => function ($data) {
                    return $data->municipio->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $ciudad,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                            return 'Esperando por resultados...';
                        } "),
                        ],
                        'ajax' => [
                            'url' => $urlCiudades,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],

            //'activo',
            'email:email',
            //'observacion:ntext',
            //'cliente_id',
            //'empresa_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
