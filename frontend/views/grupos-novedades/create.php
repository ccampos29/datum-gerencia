<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\GruposNovedades */

$this->title = 'Crear Grupo de Novedades';
$this->params['breadcrumbs'][] = ['label' => 'Grupos Novedades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-novedades-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
