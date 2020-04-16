<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposOtrosDocumentos */

$this->title = 'Actualizar Tipos Otros Documentos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Otros Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-otros-documentos-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
