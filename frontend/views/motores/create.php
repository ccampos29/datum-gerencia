<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Motores */

$this->title = 'Crear Motores';
$this->params['breadcrumbs'][] = ['label' => 'Motores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="motores-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
