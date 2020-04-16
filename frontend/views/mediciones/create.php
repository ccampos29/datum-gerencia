<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Mediciones */

$this->title = 'Crear una medicion';
$this->params['breadcrumbs'][] = ['label' => 'Mediciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mediciones-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
