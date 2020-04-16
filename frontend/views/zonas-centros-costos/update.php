<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ZonasCentrosCostos */

$this->title = 'Actualizar zonas: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Zonas Centros Costos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="zonas-centros-costos-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
