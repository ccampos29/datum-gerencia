<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposIngresos */

$this->title = 'Actualizar Tipos Ingresos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Ingresos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-ingresos-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
