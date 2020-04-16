<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Trabajos */

$this->title = 'Crear Trabajo';
$this->params['breadcrumbs'][] = ['label' => 'Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trabajos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
