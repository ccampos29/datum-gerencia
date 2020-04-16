<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposMantenimientos */

$this->title = 'Crear Tipos de Mantenimientos';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Mantenimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-mantenimientos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
