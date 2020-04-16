<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadosChecklistConfiguracion */

$this->title = 'Actualizar Estados Checklist Configuracion: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Estados Checklist Configuracions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="estados-checklist-configuracion-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
