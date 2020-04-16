<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Sistemas */

$this->title = 'Actualizar Sistemas: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Sistemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="sistemas-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
