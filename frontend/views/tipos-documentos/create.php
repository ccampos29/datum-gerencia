<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposDocumentos */

$this->title = 'Crear Tipos de Documentos';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-documentos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
