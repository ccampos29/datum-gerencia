<?php


/* @var $this yii\web\View */
/* @var $model app\models\Solicitudes */

$this->registerCssFile("@web/css/general.css", [
    'depends' => [\frontend\assets\AppAsset::className()],
]);
?>

<div class=row>
    <div class=row>
        <h1 align="center"> Solicitud N°: <?= $model->consecutivo; ?> </h1>
        <h2 align="center"> Vehiculo: <?= $model->vehiculo_id ? $model->vehiculo->placa : 'No Aplica'; ?> </h2>
        <h4 align="center"> <?= $model->creadoPor->name . " " . $model->creadoPor->surname  ?> </h4>
    </div>

    <hr>

    <div class="row">
        <h2>Detalles de la Solicitud</h2>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Fecha de la Solicitud:</b> <?= $model->fecha_hora_solicitud; ?>
            </div>
            <div class="col-md-4">
                <b>Tipo:</b> <?= $model->tipo; ?>
            </div>
            <div class="col-md-4">
                <b>Estado:</b> <?= $model->estado; ?>
            </div>
        </div>
        <p></p>
        <div class="row col-md-12">
            <div class="col-md-4">
                <b>Creada por:</b> <?= $model->creadoPor->name . " " . $model->creadoPor->surname; ?>
            </div>
            <div class="col-md-4">
                <b>Aprobada por:</b>
                <?php if ($model->estado != 'Aprobada') {
                    echo 'Sin aprobacion';
                } else {
                    echo $model->actualizadoPor->name . " " . $model->actualizadoPor->surname;
                } ?>
            </div>
        </div>
        <hr>
        <?php if (empty($repuestos)) { ?>
            <div class="row">
                <h2>Trabajos</h2>
                <div class="row col-md-12">
                    <table>
                        <tr>
                            <th align="center">Trabajo</th>
                            <th align="center">Cantidad</th>
                            <th align="center">Observacion</th>
                            <th align="center">Vehiculo</th>
                            <th align="center">Estado Solicitud</th>
                            <th align="center">Solicitud N°</th>
                        </tr>
                        <tbody>
                            <?php foreach ($trabajos as $trabajo) { ?>
                                <tr>
                                    <td>
                                        <?= $trabajo->trabajo->nombre; ?>
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
            </div>
        <?php } else { ?>
            <div class="row">
                <h2>Repuestos</h2>
                <div class="row col-md-12">
                    <table>
                        <tr>
                            <th align="center">Repuesto</th>
                            <th align="center">Cantidad</th>
                            <th align="center">Usuario Reclama</th>
                            <th align="center">Observacion</th>
                            <th align="center">Estado Solicitud</th>
                            <th align="center">Solicitud N°</th>
                        </tr>
                        <tbody>
                            <?php foreach ($repuestos as $repuesto) { ?>
                                <tr>
                                    <td>
                                        <?= $repuesto->repuesto->nombre ?>
                                    </td>
                                    <td>
                                        <?= $repuesto->cantidad ?>
                                    </td>
                                    <td>
                                        <?= $repuesto->usuarioReclama->name ?>
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
                                </tr>
                            <?php } ?>
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