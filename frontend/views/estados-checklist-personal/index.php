<?php

use common\models\User;
use frontend\models\EstadosChecklist;
use frontend\models\TiposUsuarios;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EstadosChecklistPersonalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configuracion del estado';
$this->params['breadcrumbs'][] = $this->title;
$urlUsuarios = Url::to(['user/nombres-usuarios-list']);
$usuario = empty($searchModel->usuario_id) ? '' : User::findOne($searchModel->usuario_id)->name;
$urlEstados = Url::to(['estados-checklist/estados-list']);
$estado = empty($searchModel->estado_checklist_id) ? '' : EstadosChecklist::findOne($searchModel->estado_checklist_id)->estado;
$urlTipos = Url::to(['tipos-usuarios/tipos-list']);
$tipo = empty($searchModel->tipo_usuario_id) ? '' : TiposUsuarios::findOne($searchModel->tipo_usuario_id)->descripcion;

?>
<div class="estados-checklist-personal-index">

    
    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create', 'idEstados' => $_GET['idEstados']], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $acciones = [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{view}{delete}',
            'width' => '1%',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-eye-open"></span>',
                        Yii::$app->urlManager->createUrl(['estados-checklist-personal/view', 'id' => $model->id, 'idEstados'=>$_GET['idEstados']]),
                        [
                            'title' => 'Ver',
                        ]
                    );
                },
                'update' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        Yii::$app->urlManager->createUrl(['estados-checklist-personal/update', 'id' => $model->id, 'idEstados'=>$_GET['idEstados']]),
                        [
                            'title' => 'Actualizar',
                        ]
                    );
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id, 'idEstados'=>$_GET['idEstados']], [
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
            
            'Estado del checklist' => 
            [
                'attribute' => 'estado_checklist_id',
                'value' => function ($data) {
                    return $data->estadoChecklist->estado;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por estado ...'],
                    'initValueText' => $estado,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlEstados,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'Usuario' => 
            [
                'attribute' => 'usuario_id',
                'value' => function ($data) {
                    return $data->usuario->name.' '.$data->usuario->surname;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un usuario ...'],
                    'initValueText' => $usuario,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlUsuarios,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'Tipo de usuario' => 
            [
                'attribute' => 'tipo_usuario_id',
                'value' => function ($data) {
                    return $data->tipoUsuario->descripcion;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $tipo,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlTipos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            
            'email:email',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',
            
            $acciones
        ],
    ]); ?>


</div>
