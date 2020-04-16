<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Proveedor */

$this->title = 'Creación de Proveedor';
$this->params['breadcrumbs'][] = ['label' => 'Proveedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
  <div class=" content">
<div class="proveedor-create">

<?= $this->render('_form', [
    'model' => $model,
]) ?>


   

</div></div>
