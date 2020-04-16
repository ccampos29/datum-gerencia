<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Compras */

$this->title = 'Crear Compra';
$this->params['breadcrumbs'][] = ['label' => 'Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compras-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
