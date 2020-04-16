<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Vehiculos;
/* @var $this yii\web\View */
/* @var $model frontend\models\Checklist */

$vehiculo = Vehiculos::findOne($model->vehiculo_id); 
$this->title = "Checklist Nro:".$model->consecutivo." Para el Vehiculo ".$vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Checklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="checklist-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
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
            
            'fecha_siguente',
            'fecha_checklist',
            'hora_medicion',
            'fecha_anulado',
            [
                'attribute' => 'medicion_siguente',
                'value' => number_format($model->medicion_siguente, 0, '', '.'), 
            ],
            [
                'attribute' => 'medicion_actual',
                'value' => number_format($model->medicion_actual, 0, '', '.'), 
            ],
            ['label' => 'Placa del vehiculo',
            'attribute' => 'vehiculo.placa'],
            ['label' => 'Tipo de checklist',
            'attribute' => 'tipoChecklist.nombre'],
            ['label' => 'Usuario',
            'attribute' => 'usuario.name'],
            'observacion:ntext',
            
            
        ],
    ]) ?>
    <?php if(!empty($imagenes)){?>
    <div class="row">
            <div class="col-12">
                <?= DetailView::widget([
                    'model' => $imagenes,
                    'attributes' => [
                        [
                            'attribute' => 'Imagen del checklist',
                            'value' => ' <img width="75%" src="' . Yii::$app->urlManager->createUrl('../..' . Yii::$app->params['rutaImagenesChecklist']. $imagenes->nombre_archivo) . '">',
                            'format' => 'raw'
                        ],
                    ],
                ])

                ?>
            </div>
        </div>
        <?php } ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['checklist/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>
</div>
