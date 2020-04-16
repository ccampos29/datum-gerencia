<?php


/* @var $this yii\web\View */
/* @var $model app\models\OrdenesTrabajos */

use frontend\models\Vehiculos;

$this->registerCssFile("@web/css/general.css", [
    'depends' => [\frontend\assets\AppAsset::className()],
]);

$vehiculo = Vehiculos::findOne($model->vehiculo_id);
?>

<div class=row>
    <div class=row>
        <h1 align="center"> Orden de Trabajo N°: <?= $model->consecutivo; ?> </h1>
        <h2 align="center"> Vehiculo: <?= $model->vehiculo->placa; ?> </h2>
        <h4 align="center"> <?= $model->creadoPor->name . " " . $model->creadoPor->surname  ?> </h4>
    </div>

    <hr>

    <div class="row">
        <h2>Detalles de la Orden</h2>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Fecha de la Orden:</b> <?= $model->fecha_hora_orden; ?>
            </div>
            <div class="col-md-4">
                <b>Medicion de la orden (km):</b> <?= number_format($model->medicion, 0, '', '.').'km' ?>
            </div>
            <div class="col-md-4">
                <b>Conductor:</b> <?= empty($model->usuario_conductor_id) ? 'No definido' : $model->usuarioConductor->name . " " . $model->usuarioConductor->surname ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Creada por:</b> <?= $model->creadoPor->name . " " . $model->creadoPor->surname; ?>
            </div>
            <div class="col-md-4">
                <b>Afecta disponibilidad:</b>
                <?php if ($model->disponibilidad != null) {
                    if ($model->disponibilidad == 1) {
                        echo 'Si';
                    } else {
                        echo 'No';
                    }
                } else {
                    echo 'No definido';
                } ?>
            </div>
            <div class="col-md-4">
                <b>Estado:</b> <?= $model->estado_orden ? 'Abierta' : 'Cerrada'; ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Tipo de Orden:</b> <?= $model->tipoOrden->descripcion; ?>
            </div>
            <div class="col-md-4">
                <b>Etiqueta:</b> <?= empty($model->usuario_conductor_id) ? 'No definido' : $model->etiquetaMantenimiento->nombre; ?>
            </div>
            <div class="col-md-4">
                <b>Proveedor:</b> <?= empty($model->proveedor_id) ? 'No definido' : $model->proveedor->nombre; ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
            <div class="col-md-3">
                <b>Departamento:</b> <?= empty($model->departamento_id) ? 'No definido' : $model->departamento->nombre; ?>
            </div>
            <div class="col-md-3">
                <b>Municipio:</b> <?= empty($model->municipio_id) ? 'No definido' : $model->municipio->nombre; ?>
            </div>
            <div class="col-md-3">
                <b>Centro de costos:</b> <?= empty($model->centro_costo_id) ? 'No definido' : $model->centroCosto->nombre; ?>
            </div>
            <div class="col-md-3">
                <b>Fecha de Cierre:</b> <?= $model->fecha_hora_cierre; ?>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <h2>Detalles del Vehículo</h2>
        <div class="row col-md-12">
            <div class="col-md-6">
                <b>Placa:</b> <?= $vehiculo->placa; ?>
            </div>
            <div class="col-md-6">
                <b>Marca:</b> <?= $vehiculo->marcaVehiculo->descripcion; ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Linea:</b> <?= $vehiculo->lineaVehiculo->descripcion; ?>
            </div>
            <div class="col-md-4">
                <b>Tipo:</b> <?= $vehiculo->tipoVehiculo->descripcion; ?>
            </div>
            <div class="col-md-4">
                <b>Modelo:</b> <?= $vehiculo->modelo; ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Departamento:</b> <?= empty($vehiculo->departamento_id) ? 'No definido' : $vehiculo->departamento->nombre; ?>
            </div>
            <div class="col-md-4">
                <b>Municipio:</b> <?= empty($vehiculo->municipio_id) ? 'No definido' : $vehiculo->municipio->nombre; ?>
            </div>
            <div class="col-md-4">
                <b>Centro de costos:</b> <?= empty($vehiculo->centro_costo_id) ? 'No definido' : $vehiculo->centroCosto->nombre; ?>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <h3>Observaciones</h3>
        <label><?= empty($vehiculo->observacion) ? 'Sin observacion' : $vehiculo->observacion; ?></label>
    </div>

    <hr>

    <div class="row">
        <h2>Trabajos</h2>
        <div class="row col-md-12">
            <table>
                <tr>
                    <th align="center">Trabajo</th>
                    <th align="center">Tipo Mantenimiento</th>
                    <th align="center">Costo mano de Obra</th>
                    <th align="center">Cantidad</th>
                </tr>
                <tbody>
                    <?php
                    $totalTrabajo = 0;
                    foreach ($trabajos as $trabajo) {
                        $totalTrabajo = $totalTrabajo + ($trabajo->costo_mano_obra * $trabajo->cantidad); ?>
                        <tr>
                            <td>
                                <?= $trabajo->trabajo->nombre; ?>
                            </td>
                            <td>
                                <?= $trabajo->tipoMantenimiento->nombre; ?>
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
                                <?= '$ ' . number_format($totalTrabajo, 0, '', '.') ?>
                            </b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <hr>

    <div class="row">
        <h2>Repuestos</h2>
        <div class="row col-md-12">
            <table>
                <tr>
                    <th align="center">Repuesto</th>
                    <th align="center">Proveedor</th>
                    <th align="center">Costo unitario</th>
                    <th align="center">Cantidad</th>
                </tr>
                <tbody>
                    <?php
                    $totalRepuesto = 0;
                    foreach ($repuestos as $repuesto) {
                            $totalRepuesto = $totalRepuesto + (($repuesto->costo_unitario * $repuesto->cantidad));
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
                                <?= '$ ' . number_format($totalRepuesto, 0, '', '.') ?>
                            </b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <hr>

<?php $totalOrden = $totalTrabajo + $totalRepuesto ?>
    <div class="row">
        <h2>Resumen de Costos</h2>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Total Trabajos:</b> <?= '$ ' . number_format($totalTrabajo, 0, '', '.'); ?>
            </div>
            <div class="col-md-4">
                <b>Total Repuestos:</b> <?= '$ ' . number_format($totalRepuesto, 0, '', '.'); ?>
            </div>
            <div class="col-md-4">
                <b>Total Orden de trabajo:</b> <?= '$ ' . number_format($totalOrden, 0, '', '.'); ?>
            </div>
        </div>
    </div>
</div>

<?php
if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}
?>