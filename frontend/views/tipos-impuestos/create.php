<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposImpuestos */

$this->title = 'Crear tipo de Impuestos';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Impuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-impuestos-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
