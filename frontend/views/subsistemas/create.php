<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Subsistemas */

$this->title = 'Crear Subsistema';
$this->params['breadcrumbs'][] = ['label' => 'Subsistemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subsistemas-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
