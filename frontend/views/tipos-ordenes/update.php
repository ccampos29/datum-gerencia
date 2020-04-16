<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposOrdenes */

$this->title = 'Actualizar tipo de órdenes: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Ordenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-ordenes-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
