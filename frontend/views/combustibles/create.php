<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Combustibles */

$this->title = 'Crear combustibles';
$this->params['breadcrumbs'][] = ['label' => 'Combustibles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="combustibles-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
