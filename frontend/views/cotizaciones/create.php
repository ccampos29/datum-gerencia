<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cotizaciones */

$this->title = 'Crear Cotizacion';
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index', 'idSolicitud' => $idSolicitud]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cotizaciones-create">

    <?= $this->render('_form', [
        'model' => $model,
        'idSolicitud' => $idSolicitud
    ]) ?>

</div>
