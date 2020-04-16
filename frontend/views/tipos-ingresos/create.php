<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposIngresos */

$this->title = 'Crear Tipos de Ingresos';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Ingresos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-ingresos-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
