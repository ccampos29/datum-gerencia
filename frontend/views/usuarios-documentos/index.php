<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UsuariosDocumentosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios documentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-documentos-index">

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Crear documento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            'codigo',
            'descripcion:ntext',
            'dias_alerta',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
