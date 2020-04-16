<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\MarcasMotores */

$this->title = 'Crear Marca de Motores';
$this->params['breadcrumbs'][] = ['label' => 'Marcas Motores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marcas-motores-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
