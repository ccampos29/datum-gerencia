<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClientesSucursales */

$this->title = 'Crear una sucursal';
$this->params['breadcrumbs'][] = ['label' => 'Clientes Sucursales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-sucursales-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
