<?php


/* @var $this yii\web\View */
/* @var $model app\models\Cotizaciones */

use frontend\models\Proveedores;
use frontend\models\Vehiculos;

$this->registerCssFile("@web/css/general.css", [
    'depends' => [\frontend\assets\AppAsset::className()],
]);
$proveedor = Proveedores::findOne($model->proveedor_id);
?>

<div class=row>
    <div class=row>
        <h1 align="center"> Proveedor <?= $model->proveedor->nombre; ?> </h1>
        <h2 align="center"> Solicitud N°: <?= $model->solicitud->consecutivo ?> </h2>
        <h4 align="center"> <?= $model->creadoPor->name . " " . $model->creadoPor->surname  ?> </h4>
    </div>

    <hr>

    <div class="row">
        <h2>Detalles de la Cotizacion</h2>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Fecha de la Cotizacion:</b> <?= $model->fecha_hora_cotizacion; ?>
            </div>
            <div class="col-md-4">
                <b>Fecha de Vigencia:</b> <?= $model->fecha_hora_vigencia; ?>
            </div>
            <div class="col-md-4">
                <b>Estado:</b> <?= $model->estado; ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Observacion:</b> <?= $model->observacion; ?>
            </div>
        </div>
        <hr>

        <div class="row">
        <h2>Detalles del Proveedor</h2>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Nombre:</b> <?= $proveedor->nombre; ?>
            </div>
            <div class="col-md-4">
                <b>NIT:</b> <?= $proveedor->identificacion.' - '.$proveedor->digito_verificacion; ?>
            </div>
            <div class="col-md-4">
                <b>Telefono:</b> <?= $proveedor->telefono_fijo_celular; ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Email:</b> <?= $proveedor->email; ?>
            </div>
            <div class="col-md-4">
                <b>Dirección:</b> <?= $proveedor->direccion; ?>
            </div>
            <div class="col-md-4">
                <b>Nombre de Contacto:</b> <?= $proveedor->nombre_contacto; ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Pais:</b> <?= $proveedor->pais->nombre; ?>
            </div>
            <div class="col-md-4">
                <b>Departamento:</b> <?= $proveedor->departamento->nombre; ?>
            </div>
            <div class="col-md-4">
                <b>Municipio:</b> <?= $proveedor->municipio->nombre; ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
            <div class="col-md-6">
                <b>Regimen:</b> <?= $proveedor->regimen; ?>
            </div>
            <div class="col-md-6">
                <b>Tipo de Proveedor:</b> <?= $proveedor->tipo_procedencia; ?>
            </div>
        </div>
    </div>

        <?php if (empty($repuestos)) { ?>
            <div class="row">
                <h2>Trabajos</h2>
                <div class="row col-md-12">
                    <table>
                        <tr>
                            <th align="center">Trabajo</th>
                            <th align="center">Cantidad</th>
                            <th align="center">Observacion Cliente</th>
                            <th align="center">Valor unitario</th>
                            <th align="center">Descuento</th>
                            <th align="center">Tipo de decuento</th>
                            <th align="center">Impuesto</th>
                            <th align="center">Observacion</th>
                        </tr>
                        <tbody>
                        <?php
                            $totalTrabajo = 0;
                            foreach ($trabajos as $trabajo) {
                                if ($trabajo->tipo_descuento == 1) {
                                    $tipo = '%';
                                    $totalTrabajo = $totalTrabajo + (($trabajo->valor_unitario * $trabajo->cantidad) * (1 - ($trabajo->descuento_unitario / 100)));
                                } else {
                                    $tipo = '$';
                                    $totalTrabajo = $totalTrabajo + (($trabajo->valor_unitario * $trabajo->cantidad) - $trabajo->descuento_unitario);
                                }
                            ?>
                                <tr>
                                    <td>
                                        <?= $trabajo->trabajo->nombre ?>
                                    </td>
                                    <td>
                                        <?= $trabajo->cantidad ?>
                                    </td>
                                    <td>
                                        <?= $trabajo->observacion_cliente ?>
                                    </td>
                                    <td>
                                        <?= '$ ' . number_format($trabajo->valor_unitario, 0, '', '.') ?>
                                    </td>
                                    <td align="right">
                                        <?= $trabajo->descuento_unitario ?>
                                    </td>
                                    <td>
                                        <?= $tipo ?>
                                    </td>
                                    <td>
                                        <?= $trabajo->tipoImpuesto->nombre ?>
                                    </td>
                                    <td>
                                        <?= $trabajo->observacion ?>
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
        <?php } else { ?>
            <div class="row">
                <h2>Repuestos</h2>
                <div class="row col-md-12">
                    <table>
                        <tr>
                            <th align="center">Repuesto</th>
                            <th align="center">Cantidad</th>
                            <th align="center">Observacion Cliente</th>
                            <th align="center">Valor unitario</th>
                            <th align="center">Descuento</th>
                            <th align="center">Tipo de decuento</th>
                            <th align="center">Impuesto</th>
                            <th align="center">Observacion</th>
                        </tr>
                        <tbody>
                            <?php
                            $totalRepuesto = 0;
                            foreach ($repuestos as $repuesto) {
                                if ($repuesto->tipo_descuento == 1) {
                                    $tipo = '%';
                                    $totalRepuesto = $totalRepuesto + (($repuesto->valor_unitario * $repuesto->cantidad) * (1 - ($repuesto->descuento_unitario / 100)));
                                } else {
                                    $tipo = '$';
                                    $totalRepuesto = $totalRepuesto + (($repuesto->valor_unitario * $repuesto->cantidad) - $repuesto->descuento_unitario);
                                }
                            ?>
                                <tr>
                                    <td>
                                        <?= $repuesto->repuesto->nombre ?>
                                    </td>
                                    <td>
                                        <?= $repuesto->cantidad ?>
                                    </td>
                                    <td>
                                        <?= $repuesto->observacion_cliente ?>
                                    </td>
                                    <td>
                                        <?= '$ ' . number_format($repuesto->valor_unitario, 0, '', '.') ?>
                                    </td>
                                    <td align="right">
                                        <?= $repuesto->descuento_unitario ?>
                                    </td>
                                    <td>
                                        <?= $tipo ?>
                                    </td>
                                    <td>
                                        <?= $repuesto->tipoImpuesto->nombre ?>
                                    </td>
                                    <td>
                                        <?= $repuesto->observacion ?>
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
        <?php } ?>
    </div>

    <?php
    if (class_exists('yii\debug\Module')) {
        $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
    }
    ?>