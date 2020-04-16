<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\LineasMarcas */

$this->title = 'Crear Líneas de Marcas';
$this->params['breadcrumbs'][] = ['label' => 'Lineas Marcas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lineas-marcas-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
