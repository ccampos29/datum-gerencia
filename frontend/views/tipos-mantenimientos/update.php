<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposMantenimientos */

$this->title = 'Actualizar tipo de mantenimientos: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Mantenimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-mantenimientos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
