<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\UsuariosDocumentosUsuarios */

$this->title = 'Actualizar el registro: '.$model->usuarioDocumento->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Documentos de los usuarios', 'url' => ['index', 'iUs'=>$_GET['iUs']]];
$this->params['breadcrumbs'][] = ['label' => $model->usuarioDocumento->nombre, 'url' => ['view', 'id' => $model->id, 'iUs' => $_GET['iUs']]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="usuarios-documentos-usuarios-update">

    <?= $this->render('_form', [
        'model' => $model,
        //'iUs' => $iUs

    ]) ?>

</div>
