<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesTrabajos */

$this->title = 'Crear Orden de Trabajo';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ordenes-trabajos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
