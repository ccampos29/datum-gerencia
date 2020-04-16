<?php

use frontend\models\TiposProveedores;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProveedorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proveedores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proveedor-index">


    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Proveedor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [ 
                'attribute' => 'tipo_proveedor_id',
                'value' => 'tipoProveedor.nombre',
                'filter' => ArrayHelper::map(TiposProveedores::find()->all(), 'id', 'nombre'),
                'class' => '\kartik\grid\DataColumn',
                'vAlign' => GridView::ALIGN_MIDDLE,
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Seleccionar...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ],
                ],
            ],         
            'nombre',
            'digito_verificacion',
            'identificacion',
            'telefono_fijo_celular',
            'direccion',
            //'direccion',
            //'pais_id',
            //'departamento_id',
            //'municipio_id',
            //'regimen',
            //'tipo_procedencia',
            [
                'attribute' => 'activo',
                'value' => function ($data) {
                    switch ($data->activo) {
                        case 1:
                            return '<label class="label label-success">Activo</label>';
                            break;
                        case 2:
                            return '<label class="label label-danger">Inactivo</label>';
                            break;                        
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map([['id'=>'1','descripcion'=>'Activo'],['id'=>'2','descripcion'=>'Inactivo']], 'id', 'descripcion'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            //'actualizado_por',
            //'actualizado_el',
            
            ['class' => 'yii\grid\ActionColumn',
            'header'=>'<span class="glyphicon glyphicon-list-alt"></span> ',
            'template' => '{subirAcuerdo}',
            'buttons' =>[
                'subirAcuerdo' => function ($url, $model) {     
        
                      return Html::a('<span class="glyphicon glyphicon glyphicon-list-alt "></span>', Url::to(['/acuerdo-precios', 'id' =>$model->id]), [
        
                          'title' => Yii::t('yii', 'Ver Acuerdos'),
        
                      ]);                                
        
                  }
        
              ]],
              ['class' => 'yii\grid\ActionColumn',
              'header'=>'<span class="glyphicon glyphicon glyphicon-folder-open"></span> ',
              'template' => '{upload}',
              'buttons' =>[
                  'upload' => function ($url, $model) {     
          
                        return Html::a('<span class="glyphicon glyphicon-folder-open"></span>', Url::to(['/documentos-proveedores', 'id' =>$model->id]), [
          
                            'title' => Yii::t('yii', 'Ver Documentos'),
          
                        ]);                                
          
                    }
          
                ]],
                ['class' => 'yii\grid\ActionColumn',
            'header'=>'Acciones'],
            
        ],
    ]); ?>


</div>
