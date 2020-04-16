<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\LineasMotores */

$this->title = 'Crear Líneas de Motores';
$this->params['breadcrumbs'][] = ['label' => 'Lineas Motores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lineas-motores-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
