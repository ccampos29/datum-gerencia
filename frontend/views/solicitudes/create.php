<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Solicitudes */

$this->title = 'Crear Solicitud';
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitudes-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
