<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\InventariosAjustes */

$this->title = 'Crear Ajuste';
$this->params['breadcrumbs'][] = ['label' => 'Inventarios Ajustes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventarios-ajustes-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
