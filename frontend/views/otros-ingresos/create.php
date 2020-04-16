<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OtrosIngresos */

$this->title = 'Crear';
$this->params['breadcrumbs'][] = ['label' => 'Otros Ingresos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="otros-ingresos-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
