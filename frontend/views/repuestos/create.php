<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Repuestos */

$this->title = 'Crear Repuesto';
$this->params['breadcrumbs'][] = ['label' => 'Repuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repuestos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>