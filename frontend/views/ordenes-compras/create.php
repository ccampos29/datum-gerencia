<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesCompras */

$this->title = 'Crear Orden de Compra';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ordenes-compras-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
