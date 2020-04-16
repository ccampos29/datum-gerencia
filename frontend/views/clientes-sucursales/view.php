<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\ClientesSucursales */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Clientes Sucursales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clientes-sucursales-view">

   
    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro de eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nombre',
            'codigo',
            'direccion',
            'telefono_fijo',
            'telefono_movil',
            'contacto:ntext',
            ['label' => 'Municipio',
            'attribute' => 'municipio.nombre'],
            ['label' => 'Departamento',
            'attribute' => 'departamento.nombre'],
            ['label' => 'Pais',
            'attribute' => 'pais.nombre'],
            ['label' => 'Cliente',
            'attribute' => 'cliente.nombre'],
            'activo',
            'email:email',
            'observacion:ntext',
            
            
        ],
    ]) ?>
    <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['clientes-sucursales/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
</div>
