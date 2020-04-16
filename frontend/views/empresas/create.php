<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Empresas */

$this->title = 'Crear empresa';
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresas-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelUsuario' => $modelUsuario
    ]) ?>

</div>
