<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\UsuariosDocumentosUsuarios */

$this->title = 'Asociar documento';
$this->params['breadcrumbs'][] = ['label' => 'Documentos del personal', 'url' => ['index', 'iUs'=>$_GET['iUs']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-documentos-usuarios-create">

    <?= $this->render('_form', [
        'model' => $model,
        //'iUs' => $iUs
    ]) ?>

</div>
