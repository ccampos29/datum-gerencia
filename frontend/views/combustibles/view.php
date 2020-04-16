<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\Combustibles */

$this->title = "Tanqueo con el No de tiquete: ".$model->numero_tiquete;
$this->params['breadcrumbs'][] = ['label' => 'Combustibles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="combustibles-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Esta seguro de eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'total',
            'fecha:date',
            'hora',
            'tanqueo_full',
            [
                'attribute' => 'costo_por_galon',
                'value' => '$ '.number_format($model->costo_por_galon, 0, '', '.'), 
            ],
            'cantidad_combustible',
            'observacion:ntext',
            'numero_tiquete',
            ['label' => 'Placa del vehiculo',
            'attribute' => 'vehiculo.placa'],
            ['label' => 'Tipo de combustible',
            'attribute' => 'tipoCombustible.nombre'],
            ['label' => 'Proveedores',
            'attribute' => 'proveedor.nombre'],
            ['label' => 'Usuario',
            'attribute' => 'usuario.name'],
            ['label' => 'Centro de costos',
            'attribute' => 'centroCosto.nombre'],
            ['label' => 'Municipio',
            'attribute' => 'municipio.nombre'],
            ['label' => 'Departamento',
            'attribute' => 'departamento.nombre'],
            ['label' => 'Pais',
            'attribute' => 'pais.nombre'],
            ['label' => 'Grupo del vehiculo',
            'attribute' => 'grupoVehiculo.nombre'],
            [
                'attribute' => 'tanqueo_full',
                'label'=>'Tanqueo full',
                'value' => function ($data) {
                    return ($data->tanqueo_full == 1) ? 'Si' : 'No' ;
                }
            ],
            'medicion_actual'
            
        ],
    ]) ?>

    <div class="row">
            <div class="col-12">
                <?= DetailView::widget([
                    'model' => $imagenes,
                    'attributes' => [
                        [
                            'attribute' => 'Imagen del combustible',
                            'value' => ' <img width="75%" src="' . Yii::$app->urlManager->createUrl('../..' . Yii::$app->params['rutaImagenesCombustibles']. $imagenes->nombre_archivo) . '">',
                            'format' => 'raw'
                        ],
                    ],
                ])

                ?>
            </div>
        </div>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['combustibles/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>
</div>
