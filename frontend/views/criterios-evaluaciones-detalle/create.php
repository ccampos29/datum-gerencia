<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CriteriosEvaluacionesDetalle */

$this->title = 'Configurar criterios';
$this->params['breadcrumbs'][] = ['label' => 'Configurar criterios', 'url' => ['index', 'idCriterio'=>$idCriterio]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criterios-evaluaciones-detalle-create">

    <?= $this->render('_form', [
        'model' => $model,
        'idCriterio' => $idCriterio
    ]) ?>

</div>
