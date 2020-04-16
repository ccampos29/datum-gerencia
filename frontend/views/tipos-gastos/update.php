<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposGastos */

$this->title = 'Actualizar Tipos Gastos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Gastos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-gastos-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
