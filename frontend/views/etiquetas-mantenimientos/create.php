<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EtiquetasMantenimientos */

$this->title = 'Crear Etiqueta';
$this->params['breadcrumbs'][] = ['label' => 'Etiquetas Mantenimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiquetas-mantenimientos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
