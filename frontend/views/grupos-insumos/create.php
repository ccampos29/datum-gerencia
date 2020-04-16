<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\GruposInsumos */

$this->title = 'Crear Grupos de Insumos';
$this->params['breadcrumbs'][] = ['label' => 'Grupos Insumos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-insumos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
