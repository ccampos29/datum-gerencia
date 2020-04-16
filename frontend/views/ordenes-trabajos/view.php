<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesTrabajos */

$this->title = $model->vehiculo->placa . ' - ' . $model->fecha_hora_orden;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ordenes-trabajos-view">

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
            [
                'label' => 'Vehiculo',
                'attribute' => 'vehiculo.placa'
            ],
            'fecha_hora_ingreso',
            'fecha_hora_orden',
            'fecha_hora_cierre',
            'medicion',
            [
                'label' => 'Proveedor',
                'attribute' => 'proveedor.nombre'
            ],
            [
                'label' => 'Afecta disponibilidad',
                'attribute' => 'disponibilidad',
                'value' => $model->disponibilidad ? 'Si' : 'No',
                'format' => 'raw'
            ],
            'observacion',
            [
                'label' => 'Tipo de Orden',
                'attribute' => 'tipoOrden.descripcion'
            ],
            [
                'label' => 'Estado',
                'attribute' => 'estado_orden',
                'value' => $model->estado_orden ? '<div class="label label-success">Abierta</div>' : '<div class="label label-primary">Cerrada</div>',
                'format' => 'raw'
            ],
            [
                'label' => 'Conductor',
                'attribute' => 'usuarioConductor.name'
            ],
            [
                'label' => 'Etiqueta',
                'attribute' => 'etiquetaMantenimiento.nombre'
            ],
            [
                'label' => 'Centro de Costos',
                'attribute' => 'centroCosto.nombre'
            ],
            [
                'label' => 'Municipio',
                'attribute' => 'municipio.nombre'
            ],
            [
                'label' => 'Grupo Vehiculo',
                'attribute' => 'grupoVehiculo.nombre'
            ],
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
        ],
    ]) ?>
    <?php if (!empty($trabajos)) {
        $total = 0; ?>
        <h3>Trabajos</h3>
        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Trabajo</th>
                        <th>Tipo Mantenimiento</th>
                        <th>Costo Mano de Obra</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trabajos as $trabajo) {
                        $total = $total + ($trabajo->costo_mano_obra*$trabajo->cantidad); ?>
                        <tr>
                            <td>
                                <?= $trabajo->trabajo->nombre ?>
                            </td>
                            <td>
                                <?= $trabajo->tipoMantenimiento->nombre ?>
                            </td>
                            <td>
                                <?= '$ ' . number_format($trabajo->costo_mano_obra, 0, '', '.') ?>
                            </td>
                            <td>
                                <?= $trabajo->cantidad ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2"><b>Total</b></td>
                        <td colspan="2">
                            <b>
                                <?= '$ ' . number_format($total, 0, '', '.') ?>
                            </b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning">
            <strong>No hay trabajos asociados</strong>
        </div>
    <?php } ?>

    <?php if (!empty($repuestos)) {
        $total = 0; ?>
        <h3>Repuestos</h3>
        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Repuesto</th>
                        <th>Proveedor</th>
                        <th>Costo unitario</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($repuestos as $repuesto) {
                            $total = $total + (($repuesto->costo_unitario * $repuesto->cantidad));
                    ?>
                        <tr>
                            <td>
                                <?= $repuesto->repuesto->nombre ?>
                            </td>
                            <td>
                                <?= $repuesto->proveedor->nombre ?>
                            </td>
                            <td>
                                <?= '$ ' . number_format($repuesto->costo_unitario, 0, '', '.') ?>
                            </td>
                            <td>
                                <?= $repuesto->cantidad ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2"><b>Total</b></td>
                        <td colspan="2">
                            <b>
                                <?= '$ ' . number_format($total, 0, '', '.') ?>
                            </b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning">
            <strong>No hay repuestos asociados</strong>
        </div>
    <?php } ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['ordenes-trabajos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>