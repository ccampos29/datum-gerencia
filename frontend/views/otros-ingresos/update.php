<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OtrosIngresos */

$this->title = 'Actualizar el ingreso: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Otros Ingresos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="otros-ingresos-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
