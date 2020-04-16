<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\web\UploadedFile;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosSegurosArchivos */
$this->title = $model->tipoSeguro->nombre.' - '.$model->vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Seguros Archivos', 'url' => ['index', 'idv'=>$_GET['idv'], 'idSeguro'=>$_GET['idSeguro']]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="vehiculos-seguros-archivos-view">
    
    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id,'idv'=>$_GET['idv'], 'idSeguro'=>$_GET['idSeguro']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id,'idv'=>$_GET['idv'], 'idSeguro'=>$_GET['idSeguro']], [
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
            ['label'=>'Placa del vehiculo',
            'attribute'=>'vehiculo.placa'],
            ['label' => 'Tipo de seguro',
            'attribute' => 'tipoSeguro.nombre'],
            //'nombre_archivo_original',
            //'nombre_archivo',
            //'ruta_archivo',
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
            /*'creado_por',
            'creado_el',
            'actualizado_por',
            'actualizado_el',
            'empresa_id',*/
            [
                'attribute' => 'Imagen del seguro',
                'value' => ' <img width="75%" src="'.Yii::$app->urlManager->createUrl('../..'.Yii::$app->params['rutaArchivosSeguros'] . $model->nombre_archivo).'">',
                'format' => 'raw'
            ],
            
        ],
    ]) ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-seguros-archivos/index', 'idv'=>$_GET['idv'], 'idSeguro'=>$_GET['idSeguro']]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>
</div>
