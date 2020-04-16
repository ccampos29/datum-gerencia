<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RepuestosInventariables */

$this->title = 'Crear Repuestos Inventariables';
$this->params['breadcrumbs'][] = ['label' => 'Repuestos Inventariables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repuestos-inventariables-create">

    <?= $this->render('_form', [
        'model' => $model,
        'idRepuesto' => $idRepuesto
    ]) ?>

</div>
