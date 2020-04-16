<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CuentasContables */

$this->title = 'Crear Cuenta Contable';
$this->params['breadcrumbs'][] = ['label' => 'Cuentas Contables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuentas-contables-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
