<?php

use frontend\models\CriteriosEvaluaciones;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\CriteriosEvaluacionesDetalle */

$tipo = CriteriosEvaluaciones::findOne($_GET['idCriterio'])->tipo;
$this->title = $tipo;
$this->params['breadcrumbs'][] = ['label' => 'Ver configuracion', 'url' => ['index', 'idCriterio' => $_GET['idCriterio']]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$validate_show = ($_GET['idCriterio'] != 1);

?>
<div class="criterios-evaluaciones-detalle-view">

    <p>
<!--         <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>Actualizar', ['update', 'id' => $model->id, 'idCriterio' => $model->tipo_criterio_id], ['class' => 'btn btn-primary']) ?>
 -->        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro de eliminar este item item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'label' => 'Tipo del criterio',
                'attribute' => 'tipoCriterio.tipo'
            ],
            'detalle',
            [
                'attribute' => 'rango',
                'visible' => false
            ],
            [
                'attribute' => 'minimo',
                'visible' => $validate_show
            ],
            [
                'attribute' => 'maximo',
                'visible' => $validate_show
            ]
        ],
    ]) ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['criterios-evaluaciones-detalle/index', 'idv' => $_GET['id'], 'idCriterio' => $_GET['idCriterio']]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>

</div>