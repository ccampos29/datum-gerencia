<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Novedades */

$this->title = 'Crear Novedades';
$this->params['breadcrumbs'][] = ['label' => 'Novedades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="novedades-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
