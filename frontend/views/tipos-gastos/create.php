<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposGastos */

$this->title = 'Crear Tipos Gastos';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Gastos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-gastos-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
