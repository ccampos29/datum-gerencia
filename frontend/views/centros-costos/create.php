<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CentrosCostos */

$this->title = 'Crear centro de costo';
$this->params['breadcrumbs'][] = ['label' => 'Centros de costos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="centros-costos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
