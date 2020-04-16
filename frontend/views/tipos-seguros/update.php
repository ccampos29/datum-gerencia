<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposSeguros */

$this->title = 'Actualizar Tipo de Seguros: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Seguros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-seguros-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
