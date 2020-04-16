<?php


/* @var $this yii\web\View */
/* @var $model app\models\OrdenesTrabajos */

use frontend\models\Proveedores;

$this->registerCssFile("@web/css/general.css", [
    'depends' => [\frontend\assets\AppAsset::className()],
]);
$proveedor = Proveedores::findOne($model->proveedor_id);
?>

<div class=row>
    <div class=row>
        <h1 align="center"> Orden de Compra N°: <?= $model->consecutivo; ?> </h1>
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
                <b>Proveedor:</b> <?= $model->proveedor->nombre ?>
            </div>
            <div class="col-md-4">
                <b>Forma de Pago:</b> <?= empty($model->forma_pago) ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
            <div class="col-md-6">
                <b>Creada por:</b> <?= $model->creadoPor->name . " " . $model->creadoPor->surname; ?>
            </div>
            <div class="col-md-6">
                <b>Proviene de:</b> <?= $model->proviene_de ?>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <h2>Detalles de Proveedor</h2>
        <div class="row col-md-12">
            <div class="col-md-3">
                <b>Nombre:</b> <?= $proveedor->nombre; ?>
            </div>
            <div class="col-md-3">
                <b>Identificacion/NIT:</b> <?= $proveedor->identificacion.'-'.$proveedor->digito_verificacion; ?>
            </div>
            <div class="col-md-3">
                <b>Dirección:</b> <?= $proveedor->direccion; ?>
            </div>
            <div class="col-md-3">
                <b>Tipo de Proveedor:</b> <?= $proveedor->tipoProveedor->nombre; ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Nombre Contacto:</b> <?= $proveedor->nombre_contacto; ?>
            </div>
            <div class="col-md-4">
                <b>Telefono:</b> <?= $proveedor->telefono_fijo_celular; ?>
            </div>
            <div class="col-md-4">
                <b>Email:</b> <?= $proveedor->email; ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
        <div class="col-md-4">
                <b>Pais:</b> <?= empty($proveedor->pais) ? 'No definido' : $proveedor->pais->nombre; ?>
            </div>
            <div class="col-md-4">
                <b>Departamento:</b> <?= empty($proveedor->departamento_id) ? 'No definido' : $proveedor->departamento->nombre; ?>
            </div>
            <div class="col-md-4">
                <b>Municipio:</b> <?= empty($proveedor->municipio_id) ? 'No definido' : $proveedor->municipio->nombre; ?>
            </div>
        </div>
    </div>    

    <hr>

    <div class="row">
        <h3>Observaciones</h3>
        <label><?= empty($model->observacion) ? 'Sin observacion' : $model->observacion; ?></label>
    </div>

    <hr>


    <div class="row">
        <h2>Repuestos</h2>
        <div class="row col-md-12">
            <table>
                <tr>
                    <th align="center">Repuesto</th>
                    <th align="center">Cantidad</th>
                    <th align="center">Valor unitario</th>
                    <th align="center">Descuento unitario</th>
                    <th align="center">Impuesto</th>
                    <th align="center">Observacion</th>
                    <th align="center">Total</th>
                </tr>
                <tbody>
                <?php 
                $total = 0;
                foreach ($repuestos as $repuesto) {
                        $totalRepuestos = 0;
                        if ($repuesto->tipo_descuento == 1) {
                            $total = $total + ($repuesto->valor_unitario - $repuesto->descuento_unitario)*$repuesto->cantidad;
                            $totalRepuestos = $totalRepuestos + $total;
                        } else {
                            $total = ($repuesto->valor_unitario * (1-($repuesto->descuento_unitario/100)))*$repuesto->cantidad;
                            $totalRepuestos = $totalRepuestos + $total;
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
                                <?= '$ ' . number_format($repuesto->valor_unitario, 0, '', '.') ?>
                            </td>
                            <td>
                                <?= $repuesto->tipo_descuento ? number_format($repuesto->descuento_unitario, 0, '', '.'). ' %' : '$ ' . number_format($repuesto->descuento_unitario, 0, '', '.') ?>
                            </td>
                            <td>
                                <?= $repuesto->tipoImpuesto->nombre ?>
                            </td>
                            <td>
                                <?= $repuesto->observacion ?>
                            </td>
                            <td>
                            <b>
                                <?= '$ ' . number_format($total, 0, '', '.') ?>
                            </b>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="6"><b>Total</b></td>
                        <td>
                            <b>
                                <?= '$ ' . number_format($totalRepuestos, 0, '', '.') ?>
                            </b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <hr>

    <div class="row">
        <h2>Resumen de Costos</h2>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Total Repuestos:</b> <?= '$ ' . number_format($totalRepuestos, 0, '', '.'); ?>
            </div>
            <div class="col-md-4">
                <b>Total Orden de trabajo:</b> <?= '$ ' . number_format($totalRepuestos, 0, '', '.'); ?>
            </div>
        </div>
    </div>
</div>

<?php
if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}
?>