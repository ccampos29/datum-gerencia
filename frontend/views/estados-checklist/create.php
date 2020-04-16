<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadosChecklist */

$this->title = 'Crear Estados de Checklist';
$this->params['breadcrumbs'][] = ['label' => 'Estados Checklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-checklist-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
