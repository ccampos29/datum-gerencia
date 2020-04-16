<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OtrosGastos */

$this->title = 'Crear Otros Gastos';
$this->params['breadcrumbs'][] = ['label' => 'Otros Gastos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="otros-gastos-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
