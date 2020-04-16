<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposOrdenes */

$this->title = 'Crear Tipo de Órdenes';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Ordenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-ordenes-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
