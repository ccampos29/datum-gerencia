<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Rutinas */

$this->title = 'Crear Rutina';
$this->params['breadcrumbs'][] = ['label' => 'Rutinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rutinas-create">

    <?= $this->render('_form', [
        'model' => $model,
        'tieneRutinaTrabajo' => $tieneRutinaTrabajo
    ]) ?>

</div>
