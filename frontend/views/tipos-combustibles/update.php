<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposCombustibles */

$this->title = 'Actualizar Tipos Combustibles: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Combustibles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-combustibles-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
