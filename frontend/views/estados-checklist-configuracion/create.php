<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadosChecklistConfiguracion */

$this->title = 'Crear Configuración de Estados Checklist ';
$this->params['breadcrumbs'][] = ['label' => 'Estados Checklist Configuraciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-checklist-configuracion-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
