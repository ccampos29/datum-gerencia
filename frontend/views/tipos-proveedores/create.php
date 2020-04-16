<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposProveedores */

$this->title = 'Crear Tipo de Proveedores';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Proveedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-proveedores-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
