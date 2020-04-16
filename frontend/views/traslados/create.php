<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Traslados */

$this->title = 'Crear Traslado';
$this->params['breadcrumbs'][] = ['label' => 'Traslados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traslados-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
