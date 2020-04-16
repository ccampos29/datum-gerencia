<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\UbicacionesInsumos */

$this->title = 'Crear Ubicaciones de Insumos';
$this->params['breadcrumbs'][] = ['label' => 'Ubicaciones Insumos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ubicaciones-insumos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
