<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\DocumentosProveedores */

$this->title = $model->proveedor->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Proveedores', 'url' => ['//proveedores/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="documentos-proveedores-view">


    <p>
    <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estás seguro que deseas eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute'=>'tipo_documento_id',
            'value'=>function($e){
                return $e->tipoDocumento->nombre;
            }],
            'valor_documento',
            'fecha_expedicion',
            'fecha_inicio_cubrimiento',
            'fecha_fin_cubrimiento',
            ['attribute'=>'es_actual',
            'value'=>function($e){
                return ($e->es_actual=='1') ? 'Si' : 'No';
            }],
            'observacion:ntext',
            ['attribute'=>'proveedor_id',
            'value'=>function($e){
                return $e->proveedor->nombre;
            }],
            [
                'attribute'=>'ruta_archivo',
                'label'=>'Descargar',
                'format'=>'raw',
                'value' => function ($data) {
                   return Html::a('Descargar archivo',  Yii::$app->urlManager->createUrl('../..' .Yii::$app->params['rutaArchivosProveedores']. $data->nombre_archivo));
                },
              ],
             
        ],
    ]) ?>
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>

</div>
