<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Solicitudes */

$this->title = 'Solicitud N°: ' . $model->consecutivo;
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="solicitudes-view">

    <p>
        <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Generar PDF <span class="fa fa-file-pdf-o"></span>', ['pdf', 'id' => $model->id], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'consecutivo',
            'fecha_hora_solicitud',
            [
                'attribute' => 'vehiculo_id',
                'value' => function ($data) {
                    if ($data->vehiculo_id === null) {
                        return 'No Aplica';
                    } else {
                        return $data->vehiculo->placa;
                    }
                },
                'format' => 'raw',
            ],
            'tipo',
            'estado',
            [
                'label' => 'Creada por',
                'attribute' => 'creado_por',
                'value' => function ($data) {
                    return $data->creadoPor->name . ' ' . $data->creadoPor->surname;
                },
                'format' => 'raw',
            ],
            [
                'label' => 'Aprobada por',
                'attribute' => 'actualizado_por',
                'value' => function ($data) {
                    if ($data->estado != 'Aprobada') {
                        return 'Sin aprobar';
                    } else {
                        return $data->actualizadoPor->name . ' ' . $data->actualizadoPor->surname;
                    }
                },
                'format' => 'raw',
            ],
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',
        ],
    ]) ?>

    <?php if (!empty($repuestos)) { ?>
        <h3>Repuestos</h3>
        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Repuesto</th>
                        <th>Cantidad Solicitada</th>
                        <th>Cantidad Actual</th>
                        <th>Cantidad Descargada</th>
                        <th>Usuario Reclama</th>
                        <th>Estado</th>
                        <th>Observacion</th>
                        <th>Estado Solicitud</th>
                        <th>Solicitud N°</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($repuestos as $repuesto) {
                        $cantidadSistema = 0;
                        foreach ($repuesto->repuesto->repuestosInventariables as $inventariables) {
                            $cantidadSistema = $cantidadSistema + $inventariables->cantidad;
                        } ?>
                        <tr>
                            <td>
                                <?= $repuesto->repuesto->nombre ?>
                            </td>
                            <td>
                                <?= $repuesto->cantidad ?>
                            </td>
                            <td>
                                <?= $cantidadSistema ?>
                            </td>
                            <td>
                                <?php if ($repuesto->estado != 'Descargada') {
                                    echo 0;
                                } else {
                                    echo $repuesto->cantidad;
                                } ?>
                            </td>
                            <td>
                                <?= $repuesto->usuarioReclama->name ?>
                            </td>
                            <td>
                                <?= $repuesto->estado ?>
                            </td>
                            <td>
                                <?= $repuesto->observacion ?>
                            </td>
                            <td>
                                <?= $model->estado ?>
                            </td>
                            <td>
                                <?= $model->consecutivo ?>
                            </td>
                            <td>
                                <?php if ($model->estado == 'Aprobada') {
                                    if($repuesto->estado != 'Descargada'){
                                    echo Html::a(
                                        '<i class="fa fa-download" aria-hidden="true"></i> Descargar',
                                        Yii::$app->urlManager->createUrl(['solicitudes/descargar-repuesto', 'idRepuesto' => $repuesto->id]),
                                        [
                                            'class' => 'btn btn-primary'
                                        ]
                                    );
                                }
                                } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <h3>Trabajos</h3>
        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Trabajo</th>
                        <th>Cantidad</th>
                        <th>Observacion</th>
                        <th>Vehiculo</th>
                        <th>Estado Solicitud</th>
                        <th>Solicitud N°</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trabajos as $trabajo) { ?>
                        <tr>
                            <td>
                                <?= $trabajo->trabajo->nombre ?>
                            </td>
                            <td>
                                <?= $trabajo->cantidad ?>
                            </td>
                            <td>
                                <?= $trabajo->observacion ?>
                            </td>
                            <td>
                                <?= $model->vehiculo->placa ?>
                            </td>
                            <td>
                                <?= $model->estado ?>
                            </td>
                            <td>
                                <?= $model->consecutivo ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['solicitudes/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>