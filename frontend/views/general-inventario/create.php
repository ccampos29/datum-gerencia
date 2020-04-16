<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\GeneralInventario */

$this->title = 'Create General Inventario';
$this->params['breadcrumbs'][] = ['label' => 'General Inventarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="general-inventario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
