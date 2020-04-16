<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\InformacionAdicionalUsuarios */

$this->title = 'Informacion adicional';
//$this->params['breadcrumbs'][] = ['label' => 'Informacion Adicional Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informacion-adicional-usuarios-create">

    <h1><?= 'Informacion adicional del usuario: '.$usuario->name.' '.$usuario->surname;?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'usuario' => $usuario
    ]) ?>

</div>
