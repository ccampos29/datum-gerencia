<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AlertasUsuarios */

$this->title = 'Crear alerta';
$this->params['breadcrumbs'][] = ['label' => 'Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alertas-usuarios-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
