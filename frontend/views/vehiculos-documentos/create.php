<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosOtrosDocumentos */

$this->title = 'Crear otros documentos para los vehiculos';
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Otros Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculos-otros-documentos-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
