<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\GruposInsumos */

$this->title = 'Actualizar Grupos Insumos: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Grupos Insumos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="grupos-insumos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
