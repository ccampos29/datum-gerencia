<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Combustibles */

$this->title = 'Actualizar el tanqueo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Combustibles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->numero_tiquete, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="combustibles-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
