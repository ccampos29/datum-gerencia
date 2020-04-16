<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\MarcasMotores */

$this->title = 'Actualizar Marca de Motores: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Marcas Motores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="marcas-motores-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
