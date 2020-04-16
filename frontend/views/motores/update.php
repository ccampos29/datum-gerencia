<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Motores */

$this->title = 'Actualizar Motores: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Motores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="motores-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
