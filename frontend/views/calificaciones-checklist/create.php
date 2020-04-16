<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CalificacionesChecklist */

$this->title = 'Calificar checklist';

?>
<div class="calificaciones-checklist-create">

    <?= $this->render('_form', [
        'model' => $model,
        'idChecklist' => $idChecklist,
        'idv' => $idv,
        'idTipo' => $idTipo,
    ]) ?>

</div>