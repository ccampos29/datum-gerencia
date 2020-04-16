<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\NovedadesMantenimientos */

$this->title = 'Crear Novedad de Mantenimiento';
$this->params['breadcrumbs'][] = ['label' => 'Novedades Mantenimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="novedades-mantenimientos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
