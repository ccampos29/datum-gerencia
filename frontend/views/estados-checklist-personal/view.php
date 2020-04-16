<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadosChecklistPersonal */

$this->title = "Configuracion para " . $model->estadoChecklist->estado;
$this->params['breadcrumbs'][] = ['label' => 'Configuracion estados', 'url' => ['index', 'idEstados'=>$_GET['idEstados']]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="estados-checklist-personal-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id, 'idEstados'=>$_GET['idEstados']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id, 'idEstados'=>$_GET['idEstados']], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Esta seguro de eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            ['label' => 'Estado del checklist',
            'attribute' => 'estadoChecklist.estado'],
            ['label' => 'Usuario',
            'attribute' => 'usuario.name'],
            ['label' => 'Tipo de usuario',
            'attribute' => 'tipoUsuario.descripcion'],
            'email:email',
        ],
    ]) ?>

</div>