<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\UnidadesMedidas */

$this->title = 'Crear Unidad de Medida';
$this->params['breadcrumbs'][] = ['label' => 'Unidades Medidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unidades-medidas-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
