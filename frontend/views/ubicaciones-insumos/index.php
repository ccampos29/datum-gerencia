<?php

use frontend\models\UbicacionesInsumosUsuarios;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UbicacionesInsumosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ubicaciones Insumos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ubicaciones-insumos-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            'codigo_interno',
            'activo',
            'observacion:ntext',
            ['label'=>'Usuarios Registrados',
            'value'=>function($data){                    
                $count = UbicacionesInsumosUsuarios::find()->where(['ubicacion_insumo_id'=>$data->id])->count();
                if($count>0){
                    return '<span class="user_count" style="background-color:green">'.$count.'</span>';
                }
                return '<span class="user_count" style="background-color:red">0</span>';
            },'format'=>'raw'
        ],
            //'empresa_id',
            
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
