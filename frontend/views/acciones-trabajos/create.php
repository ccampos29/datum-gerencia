<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AccionesTrabajos */

$this->title = 'Crear Acciones Trabajos';
$this->params['breadcrumbs'][] = ['label' => 'Acciones Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acciones-trabajos-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
