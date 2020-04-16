<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CuentasContablesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cuentas Contables';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuentas-contables-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Cuenta Contable', ['create'], ['class' => 'btn btn-success']) ?>
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
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
