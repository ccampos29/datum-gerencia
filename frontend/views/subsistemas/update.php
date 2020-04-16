<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Subsistemas */

$this->title = 'Actualizar Subsistema: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Subsistemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="subsistemas-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
