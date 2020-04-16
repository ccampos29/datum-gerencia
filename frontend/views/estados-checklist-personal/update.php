<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadosChecklistPersonal */

$this->title = 'Actualizar: ' . $model->estadoChecklist->estado;
$this->params['breadcrumbs'][] = ['label' => 'Estados Checklist Personals', 'url' => ['index', 'idEstados'=>$_GET['idEstados']]];
$this->params['breadcrumbs'][] = ['label' => 'Configuracion estado', 'url' => ['view', 'id' => $model->id, 'idEstados'=>$_GET['idEstados']]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="estados-checklist-personal-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
