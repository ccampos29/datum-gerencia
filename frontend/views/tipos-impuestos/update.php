<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposImpuestos */

$this->title = 'Actualizar Tipo de Impuestos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Impuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-impuestos-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
