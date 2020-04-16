<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\GeneralInventario */

$this->title = 'Update General Inventario: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'General Inventarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="general-inventario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
