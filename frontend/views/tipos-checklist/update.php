<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposChecklist */

$this->title = 'Actualizar el tipo de cheklist: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Checklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-checklist-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
