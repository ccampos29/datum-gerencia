<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Sistemas */

$this->title = 'Crear Sistemas';
$this->params['breadcrumbs'][] = ['label' => 'Sistemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sistemas-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
