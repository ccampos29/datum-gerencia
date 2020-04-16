<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadosChecklistPersonal */

$this->title = 'Configuracion del estado';
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index','idEstados'=>$_GET['idEstados']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-checklist-personal-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
