<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AcuerdoPrecios */

$this->title = 'Actualizar Acuerdo Precios: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Acuerdo Precios', 'url' => ['index',"id"=>$_GET['id']]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="acuerdo-precios-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
