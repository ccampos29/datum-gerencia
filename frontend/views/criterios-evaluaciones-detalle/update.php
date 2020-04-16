<?php

use frontend\models\CriteriosEvaluaciones;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CriteriosEvaluacionesDetalle */
$tipo=CriteriosEvaluaciones::findOne($_GET['idCriterio'])->tipo;
$this->title = 'Actualizar la configuracion de: ' . $tipo;
$this->params['breadcrumbs'][] = ['label' => 'Configurar criterios', 'url' => ['index', 'idCriterio'=>$idCriterio]];
$this->params['breadcrumbs'][] = ['label' => $tipo, 'url' => ['view', 'id' => $model->id, 'idCriterio'=>$idCriterio]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="criterios-evaluaciones-detalle-update">

    <?= $this->render('_form', [
        'model' => $model,
        'idCriterio' => $idCriterio
    ]) ?>

</div>
