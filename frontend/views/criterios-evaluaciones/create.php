<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CriteriosEvaluaciones */

$this->title = 'Crear Criterios de Evaluación';
$this->params['breadcrumbs'][] = ['label' => 'Criterios Evaluaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criterios-evaluaciones-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
