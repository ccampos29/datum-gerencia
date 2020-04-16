<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposUsuarios */

$this->title = 'Crear tipo de usuario';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de usuario', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-usuarios-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
