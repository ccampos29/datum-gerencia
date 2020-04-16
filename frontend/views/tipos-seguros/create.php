<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposSeguros */

$this->title = 'Crear Tipos de Seguros';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Seguros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-seguros-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
