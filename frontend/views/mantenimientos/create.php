<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Mantenimientos */

$this->title = 'Crear Mantenimiento';
$this->params['breadcrumbs'][] = ['label' => 'Mantenimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mantenimientos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
