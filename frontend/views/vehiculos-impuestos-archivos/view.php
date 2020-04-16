<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosImpuestosArchivos */

$this->title = $model->tipoImpuesto->nombre.' - '.$model->vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Impuestos Archivos', 'url' => ['index','idv'=>$_GET['idv'],'idImpuesto'=>$_GET['idImpuesto']]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$url='/frontend/web/archivos/impuestos/';
?>
<div class="vehiculos-impuestos-archivos-view">

    
    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id, 'idv'=>$_GET['idv'],'idImpuesto'=>$_GET['idImpuesto']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id, 'idv'=>$_GET['idv'],'idImpuesto'=>$_GET['idImpuesto']], [
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
            //'id',
            ['label'=>'Placa del vehiculo',
            'attribute'=>'vehiculo.placa'],
            ['label' => 'Tipo de impuesto',
            'attribute' => 'tipoImpuesto.nombre'],
            
            [
                'attribute'=>'images',
                'value'=> Yii::$app->homeUrl.'uploads/'.$model->nombre_archivo,
                'format' => ['image',['width'=>'100','height'=>'100']],
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
                'attribute' => 'Imagen del impuesto',
                'value' => ' <img width="75%" src="'.Yii::$app->urlManager->createUrl('../..'.Yii::$app->params['rutaArchivosImpuestos'] . $model->nombre_archivo).'">',
                'format' => 'raw'
            ],
            
        ],
    ]) 
    ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-impuestos-archivos/index', 'idv'=>$_GET['idv'], 'idImpuesto'=>$_GET['idImpuesto']]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>

</div>
