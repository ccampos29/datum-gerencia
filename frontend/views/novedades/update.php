<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Novedades */

$this->title = 'Actualizar Novedades: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Novedades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="novedades-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
