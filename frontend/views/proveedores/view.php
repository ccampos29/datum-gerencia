<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Proveedor */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Proveedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="proveedor-view">


    <p>
        <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro que desea eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'tipo_proveedor_id',
                'value' => function ($data) {
                    return $data->tipoProveedor->nombre;
                }
            ],
            'nombre',
            'identificacion',
            'digito_verificacion',
            'telefono_fijo_celular',
            'email:email',
            'direccion',
            'nombre_contacto',
            [
                'attribute' => 'pais_id',
                'value' => function ($data) {
                    return $data->pais->nombre;
                }
            ],
            [
                'attribute' => 'departamento_id',
                'value' => function ($data) {
                    return $data->departamento->nombre;
                }
            ],
            [
                'attribute' => 'municipio_id',
                'value' => function ($data) {
                    return $data->municipio->nombre;
                }
            ],
            'regimen',
            'tipo_procedencia',
            [
                'attribute' => 'activo',
                'label'=>'Estado',
                'value' => function ($data) {
                    return ($data->activo == 1) ? 'Activo' : 'Inactivo' ;
                }
            ],
        ],
    ]) ?>
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>

</div>
