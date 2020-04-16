<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposChecklist */

$this->title = 'Crear Tipos de Checklist';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Checklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-checklist-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
