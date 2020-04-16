<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;
use backend\models\AuthItem;
use common\widgets\Titulo;
use common\models\User;
use common\models\TipoAutenticacion;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model administracion\models\pruebas\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Parametrización básica';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <?php
    $attributes = [
        'id_number',
        'name',
        'surname',
        'username',
        'email:email',
        [
            'attribute' => 'estado',
            'format' => 'raw',
            'value' => $model->estado ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>',
            'type' => DetailView::INPUT_SWITCH,
            'widgetOptions' => [
                'pluginOptions' => [
                    'onText' => 'Activo',
                    'offText' => 'Inactivo',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ]
            ],
        ],
        [
            'label' => 'Gestión de contraseña y activación de cuenta',
            'value' => Html::a(
                '<span class="glyphicon glyphicon-lock"></span> Cambiar contraseña',
                Yii::$app->urlManager->createUrl(['user/cambiar-contrasena', 'email' => $model->email, 'id' => $model->id]),
                [
                    'class' => 'btn btn-primary btn-sm'
                ]
            ) .
                ' ' .
                Html::a(
                    '<span class="glyphicon glyphicon-envelope"></span> Reenviar correo de activación',
                    Yii::$app->urlManager->createUrl(['user/reenviar-correo-activacion', 'id' => $model->id]),
                    [
                        'class' => 'btn btn-warning btn-sm'
                    ]
                ),
            'format' => 'raw'
        ],

    ];

    echo DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
        'panel' => [
            'type' => DetailView::TYPE_PRIMARY,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Datos generales </h3>',
        ],
        'buttons1' => '{update}',
        'responsive' => true,
        'hover' => true,
        'hAlign' => DetailView::ALIGN_LEFT,
        'vAlign' => DetailView::ALIGN_CENTER,
    ]);
    ?>
    <?php if(!empty($informacionAdicional)) :?>
    <?= DetailView::widget([
        'model' => $informacionAdicional,
        'panel' => [
            'type' => DetailView::TYPE_PRIMARY,
            'heading' => '<h3 class="panel-title"><i class="fa fa-address-card"></i> Información complementaria </h3>',
        ],
        'buttons1' => '',
        'attributes' => [
            'direccion',
            [
                'attribute' => 'pais_id',
                'value' => !empty($informacionAdicional->pais_id)?$informacionAdicional->pais->nombre:'No definido'
            ],
            [
                'attribute' => 'departamento_id',
                'value' => !empty($informacionAdicional->departamento_id)?$informacionAdicional->departamento->nombre:'No definido'
            ],
            [
                'attribute' => 'municipio_id',
                'value' => !empty($informacionAdicional->municipio_id)?$informacionAdicional->municipio->nombre:'No definido'
            ],
            
            'numero_movil',
            'numero_fijo_extension',
            [
                'attribute' => 'numero_cuenta_bancaria',
                'value' => !empty($informacionAdicional->numero_cuenta_bancaria)?$informacionAdicional->numero_cuenta_bancaria:'No definido'
            ],
            [
                'attribute' => 'tipo_cuenta_bancaria',
                'value' => !empty($informacionAdicional->tipo_cuenta_bancaria)?$informacionAdicional->tipo_cuenta_bancaria:'No definido'
            ],
            [
                'attribute' => 'nombre_banco',
                'value' => !empty($informacionAdicional->nombre_banco)?$informacionAdicional->nombre_banco:'No definido'
            ],
            
        ],
    ]) ?>

    <?php endif ?>



</div>