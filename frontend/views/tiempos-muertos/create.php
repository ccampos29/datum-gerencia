<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiemposMuertos */

$this->title = 'Crear Tiempos Muertos';
$this->params['breadcrumbs'][] = ['label' => 'Tiempos Muertos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tiempos-muertos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
