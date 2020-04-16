<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\InformacionAdicionalUsuarios */

$this->title = 'Update Informacion Adicional Usuarios: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Informacion Adicional Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="informacion-adicional-usuarios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
