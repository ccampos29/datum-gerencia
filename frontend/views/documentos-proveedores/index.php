<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DocumentosProveedoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documentos de Proveedores';
$this->params['breadcrumbs'][] = ['label' => 'Proveedores', 'url' => ['//proveedores/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentos-proveedores-index">


    <p>
        <?= Html::a('<span class="glyphicon glyphicon-open"></span> Subir Documento', ['create', 'id' =>$_GET['id']], ['class' => 'btn btn-success']) ?>
    </p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'tipo_documento_id',
                'value' => function ($data) {
                    return $data->tipoDocumento->nombre;
                }
            ],
            'valor_documento',
            'fecha_expedicion',
            'fecha_inicio_cubrimiento',
            'fecha_fin_cubrimiento',
             [
                'attribute' => 'es_actual',
                'value' => function ($data) {
                    switch ($data->es_actual) {
                        case 1:
                            return '<label class="label label-success">Actual</label>';
                            break;
                        case 0:
                            return '<label class="label label-danger">Inactivo</label>';
                            break;                        
                    }
                },
                'format' => 'raw',
            ],
            //'observacion:ntext',
            //'proveedor_id',
            //'nombre_archivo_original',
            //'nombre_archivo',
            //'ruta_archivo',
           
            //'actualizado_por',
            //'actualizado_el',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view}{update}  {delete}',
                
                ],
        ],
    ]); ?>


</div>
