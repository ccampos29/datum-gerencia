<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Empresas */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="empresas-view">

    <p>
        <?= Html::a('<span class="fa fa-pencil-square-o"></span> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="fa fa-trash"></span> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            'nit_identificacion',
            'digito_verificacion',
            'numero_fijo',
            'numero_celular',
            'correo_contacto',
            'direccion',
            [
                'attribute' => 'estado',
                'value' => ($model->estado)? '<div class="label label-success">Activo</div>':'<div class="label label-warning">Inactiva</div>',
                'format' => 'raw'
            ],
            'fecha_inicio_licencia',
            'fecha_fin_licencia',
            'tipo',
        ],
    ]) ?>

</div>
