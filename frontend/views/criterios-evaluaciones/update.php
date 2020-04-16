<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CriteriosEvaluaciones */

$this->title = 'Actualizar Criterios Evaluaciones: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Criterios Evaluaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="criterios-evaluaciones-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
