<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\UsuariosDocumentosUsuarios */

$this->title = $model->usuarioDocumento->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios Documentos Usuarios', 'url' => ['index', 'iUs'=>  $_GET['iUs']]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-documentos-usuarios-view">

    
<p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id, 'iUs' => $_GET['iUs']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id, 'iUs' => $_GET['iUs']], [
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
            ['label'=> 'Documento',
            'attribute'=> 'usuarioDocumento.nombre'],
            ['label'=> 'Usuario',
            'attribute'=> 'usuario.name'],
            ['label'=> 'Proveedor',
            'attribute'=> 'proveedor.nombre'],
            'codigo',
            'valor_documento',
            
            [
                'attribute' => 'actual',
                'value' => function ($data) {
                    switch ($data->actual) {
                        case 1:
                            return '<label class="label label-success">Activo</label>';
                            break;
                        case 0:
                            return '<label class="label label-warning">Inactivo</label>';
                            break;
                    }
                },
                'format' => 'raw',
            ],
            'observacion:ntext',
            'fecha_expedicion:date',
            'fecha_expiracion:date',
            ['label'=> 'Centros de costos',
            'attribute'=> 'centroCosto.nombre'],
            [
                'attribute'=>'ruta_archivo',
                'label'=>'Descargar',
                'format'=>'raw',
                'value' => function ($data) {
                   return Html::a('Descargar archivo',  Yii::$app->urlManager->createUrl('../..' .Yii::$app->params['rutaArchivosDocumentosUsuarios']. $data->nombre_archivo));
                },
              ],
        ],
    ]) ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['usuarios-documentos-usuarios/index', 'iUs' => $_GET['iUs']]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>
