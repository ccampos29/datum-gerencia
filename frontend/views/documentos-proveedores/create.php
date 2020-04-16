<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\DocumentosProveedores */

$this->title = 'Subir Documentos';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentos-proveedores-create">


    <?= $this->render('_form', [
        'model' => $model,
        'proveedor_id'=>$proveedor_id
    ]) ?>

</div>
