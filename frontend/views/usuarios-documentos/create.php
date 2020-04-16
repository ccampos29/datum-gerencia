<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\UsuariosDocumentos */

$this->title = 'Crear un documento';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-documentos-create">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
