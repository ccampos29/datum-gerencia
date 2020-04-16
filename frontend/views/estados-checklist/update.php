<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadosChecklist */

$this->title = 'Actualizar el estado de checklist: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Estados Checklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="estados-checklist-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
