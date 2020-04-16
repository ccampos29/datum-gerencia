<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Repuestos */

$this->title = 'Actualizar Repuesto: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Repuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="repuestos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
