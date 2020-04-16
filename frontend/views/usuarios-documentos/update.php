<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\UsuariosDocumentos */

$this->title = 'Actualizar el documento: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="usuarios-documentos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
