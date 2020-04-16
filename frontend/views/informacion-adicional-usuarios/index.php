<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\InformacionAdicionalUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Informacion Adicional Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informacion-adicional-usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Informacion Adicional Usuarios', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'direccion',
            'pais_id',
            'departamento_id',
            'municipio_id',
            //'numero_movil',
            //'numero_fijo_extension',
            //'numero_cuenta_bancaria',
            //'tipo_cuenta_bancaria',
            //'nombre_banco',
            //'usuario_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
