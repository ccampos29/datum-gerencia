<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposCombustibles */

$this->title = 'Crear Tipos de Combustibles';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Combustibles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-combustibles-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
