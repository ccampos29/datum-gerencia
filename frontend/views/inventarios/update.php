<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Inventarios */

$this->title = 'Actualizar Inventarios: ' . $model->ubicacionInsumo->nombre.' - '.$model->fecha_hora_inventario;
$this->params['breadcrumbs'][] = ['label' => 'Inventarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ubicacionInsumo->nombre.' - '.$model->fecha_hora_inventario, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="inventarios-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
