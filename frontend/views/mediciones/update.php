<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Mediciones */

$this->title = 'Actualizar la medicion: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mediciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="mediciones-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
