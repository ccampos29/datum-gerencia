<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AcuerdoPrecios */

$this->title = 'Crear Acuerdo de Precios';
$this->params['breadcrumbs'][] = ['label' => 'Proveedores', 'url' => ['//proveedores/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acuerdo-precios-create">


    <?= $this->render('_form', [
        'model' => $model,
        'proveedor_id' => $proveedor_id
    ]) ?>

</div>
