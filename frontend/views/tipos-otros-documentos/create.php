<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposOtrosDocumentos */

$this->title = 'Crear Tipos Otros Documentos';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Otros Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-otros-documentos-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
