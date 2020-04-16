<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CuentasContables */

$this->title = 'Actualizar Cuentas Contables: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Cuentas Contables', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="cuentas-contables-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
