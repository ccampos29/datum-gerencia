<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Checklist */

$this->title = 'Crear checklist';
$this->params['breadcrumbs'][] = ['label' => 'Checklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checklist-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
