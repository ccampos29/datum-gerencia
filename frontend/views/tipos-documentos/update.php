<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposDocumentos */

$this->title = 'Actualizar Tipos de Documentos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-documentos-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
