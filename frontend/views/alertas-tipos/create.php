<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AlertasTipos */

$this->title = 'Crear tipo de alerta';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alertas-tipos-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
