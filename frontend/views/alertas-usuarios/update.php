<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AlertasUsuarios */

$this->title = 'Actualizar alerta';
$this->params['breadcrumbs'][] = ['label' => 'Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="alertas-usuarios-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
