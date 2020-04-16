<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ZonasCentrosCostos */

$this->title = 'Crear Zonas';
$this->params['breadcrumbs'][] = ['label' => 'Zonas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zonas-centros-costos-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
