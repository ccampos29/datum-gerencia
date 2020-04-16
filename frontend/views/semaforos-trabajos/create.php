<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\SemaforosTrabajos */

$this->title = 'Crear Semaforos Trabajos';
$this->params['breadcrumbs'][] = ['label' => 'Semaforos Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semaforos-trabajos-create">


    <?= $this->render('_form', [
        'model' => $model,
        'indicadores'=>$indicadores,
        'semaforos'=>$semaforos 
    ]) ?>

</div>
