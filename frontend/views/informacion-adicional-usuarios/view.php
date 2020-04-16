<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\InformacionAdicionalUsuarios */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Informacion Adicional Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="informacion-adicional-usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'direccion',
            'pais_id',
            'departamento_id',
            'municipio_id',
            'numero_movil',
            'numero_fijo_extension',
            'numero_cuenta_bancaria',
            'tipo_cuenta_bancaria',
            'nombre_banco',
            'usuario_id',
            'creado_por',
            'creado_el',
            'actualizado_por',
            'actualizado_el',
        ],
    ]) ?>

</div>
