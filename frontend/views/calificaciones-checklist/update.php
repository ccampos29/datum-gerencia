<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CalificacionesChecklist */

$this->title = 'Update Calificaciones Checklist: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Calificaciones Checklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="calificaciones-checklist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
