<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosDocumentosArchivos */

$this->title = $model->tipoDocumento->nombre.' - Vehiculo: '.$model->vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Documentos Archivos', 'url' => ['index', 'idv'=>$_GET['idv'], 'idDocumento'=>$_GET['idDocumento']]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehiculos-documentos-archivos-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id,'idv' => $_GET['idv'], 'idDocumento' => $_GET['idDocumento']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id,'idv' => $_GET['idv'], 'idDocumento' => $_GET['idDocumento']], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'label'=>'Placa del vehiculo',
                'attribute'=>'vehiculo.placa'
            ],
            [
                'label'=>'Tipo del documento',
                'attribute'=>'tipoDocumento.nombre'
            ],
            
            [
                'attribute' => 'es_actual',
                'value' => function ($data) {
                    switch ($data->es_actual) {
                        case 1:
                            return '<label class="label label-success">Activo</label>';
                            break;
                        case 0:
                            return '<label class="label label-warning">Inactivo</label>';
                            break;
                    }
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'Imagen del documento',
                'value' => ' <img width="75%" src="'.Yii::$app->urlManager->createUrl('../..'.Yii::$app->params['rutaArchivosDocumentosV'] . $model->nombre_archivo).'">',
                'format' => 'raw'
            ],
            
        ],
    ]) ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-documentos-archivos/index','idv' => $_GET['idv'], 'idDocumento' => $_GET['idDocumento']]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>

</div>
