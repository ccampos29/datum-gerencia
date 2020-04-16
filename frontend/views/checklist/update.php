<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Checklist */

$this->title = 'Actualizar: '.$model->vehiculo->placa.' - '.$model->fecha_checklist;
$this->params['breadcrumbs'][] = ['label' => 'Checklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="checklist-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
