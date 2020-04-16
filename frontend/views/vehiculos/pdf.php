<?php

use kartik\helpers\Html;

/* @var $this yii\web\View */
/* @var $model aplicacion\models\contrato */

$this->registerCssFile("@web/css/general.css", [
    'depends' => [\frontend\assets\AppAsset::className()],
]);
if(is_string($grupos)){
    $var = 2;
}else{
    if(count($grupos)>1){
        $var=1;
    }else{
        $var=0;
    }    
}
?>  
<div class="container-fluid col-12">
    <div class="row">
        <h2 align="center"><?= $model->placa . " - " . $model->marcaVehiculo->descripcion . ' ' . $model->lineaVehiculo->descripcion . " - " . $model->tipoVehiculo->descripcion ?> <br></h2>
        <hr>
        <br>
        <br>
        <b>Imagen del vehiculo</b><br><br>
        <?= '<img width="60%" src="' . Yii::$app->urlManager->createUrl('../..' . Yii::$app->params['rutaImagenesVehiculos'].'vehiculo'.$imagenes->vehiculo_id.'/'.$imagenes->nombre_archivo) . '">' ?> <br><br>
        <b>Registrado desde: </b><?= $model->creado_el ?> <br>
        <b>Registrado por: </b><?= $model->creadoPor->name . ' ' . $model->creadoPor->surname ?> <br>
        <b>Medicion actual: </b><?= number_format($wservice[0], 0, '', '.').' ('.$wservice[1].')'?> <br>
        <b>Conductor actual: </b><?php if(!empty($conductor)){ if($conductor->estado==1 && $conductor->principal==1){ echo $conductor->conductor->name.' '.$conductor->conductor->surname;}else { echo 'No hay un conductor actual o principal';}}else{ echo 'No hay informacion asociada';}  ?> <br>
        <b>Modelo: </b><?= $model->modelo ?> <br>
        <b>Color: </b><?= $model->color ?> <br>
        <b>Tipo de medicion: </b><?= $model->tipo_medicion ?> <br>
        <b>Tipo de trabajo: </b><?= $model->tipo_trabajo ?> <br>
        <b>Combustible: </b><?= $model->tipoCombustible->nombre ?> <br>
        <hr>
    </div>

    <div class="row">
        <h2><?= "Uso del Vehiculo" ?> <br></h2>
        <hr>
        <b>Distancia maxima por dia: </b><?php if ($model->distancia_maxima > 0) {
                                                echo $model->distancia_maxima . ' km';
                                            } else {
                                                echo 'No hay informacion asociada';
                                            } ?> <br>
        <b>Distancia promedio por dia: </b><?php if ($model->distancia_promedio > 0) {
                                                echo $model->distancia_promedio . ' km';
                                            } else {
                                                echo 'No hay informacion asociada';
                                            } ?> <br>
        <b>Horas de trabajo diarias: </b><?php if ($model->horas_dia > 0) {
                                                echo $model->horas_dia . ' h';
                                            } else {
                                                echo 'No hay informacion asociada';
                                            } ?> <br>
    </div>
    <div class="row">
        <h2><?= "Datos de Agrupacion" ?> <br></h2>
        <hr>
        <b>Pais: </b><?= $model->pais->nombre ?> <br>
        <b>Municipio: </b><?= $model->municipio->nombre ?> <br>
        <b>Ciudad: </b><?= $model->departamento->nombre ?> <br>
        <b>Centro de Costos: </b><?= $model->centroCosto->nombre ?> <br>
        <?php if(is_string($grupos)){?>
            <b>Primer Grupo: </b><?= $grupos ?> <br>
            <b>Segundo Grupo: </b><?= $grupos ?> <br>
            <?php }else{
                if(count($grupos)>1){?>
                    <b>Primer Grupo: </b><?= $grupos[0] ?> <br>
                    <b>Segundo Grupo: </b><?= $grupos[1] ?> <br>
                <?php }else{ ?>
                    <b>Primer Grupo: </b><?= $grupos[0] ?> <br>
                <?php }    
            }?>
        <b>Observacion: </b><?php if ($model->observaciones) {
                                echo $model->observaciones;
                            } else {
                                echo 'No hay informacion asociada';
                            } ?> <br>
    </div>
    <hr>
    <div class="row">
        <h2><?= "Mas Datos" ?> <br></h2>
        <hr>
        <b>Identificacion Auxiliar: </b><?= $model->identificacion_auxiliar ?> <br>
        <b>Imei GPS: </b><?php if ($model->vehiculo_imei_gps != null) {
                                echo $model->vehiculo_imei_gps;
                            } else {
                                echo 'No hay informacion asociada';
                            }  ?> <br>
        <b>Propietario del Vehiculo: </b><?= $model->propietario_vehiculo ?> <br>
        <b>Numero de chasis: </b><?= $model->numero_chasis ?> <br>
        <b>Marca del Motor: </b><?= $model->motor->nombre ?> <br>
        <b>Linea del Motor: </b><?= $model->lineaMotor->descripcion ?> <br>
        <b>Numero de Serie: </b><?= $model->numero_serie ?> <br>
        <b>Tipo de Carroceria: </b><?= $model->tipo_carroceria ?> <br>
        <b>Cantidad de Sillas: </b><?= $model->cantidad_sillas ?> <br>
        <b>Toneladas de Carga: </b><?php if ($model->toneladas_carga != null) {
                                        echo $model->toneladas_carga;
                                    } else {
                                        echo 'No hay informacion asociada';
                                    }  ?> <br>
        <b>Codigo Fasecolda: </b><?= $model->codigo_fasecolda ?> <br>
        <b>Tipo de Servicio: </b><?= $model->tipo_servicio ?> <br>
    </div>
    <div class="row">
        <h2><?= "Datos de Compra" ?> <br></h2>
        <hr>
        <b>Nombre del Vendedor: </b><?php if ($model->nombre_vendedor != null) {
                                        echo $model->nombre_vendedor;
                                    } else {
                                        echo 'No hay informacion asociada';
                                    }  ?> <br>
        <b>Precio de Compra: </b><?= '$ '.number_format($model->precio_compra,0,'','.') ?> <br>
        <b>Fecha de Compra: </b><?= $model->fecha_compra ?> <br>
        <b>Precio de Accesorios: </b><?php if ($model->precio_accesorios != null) {
                                            echo '$ '.number_format($model->precio_accesorios,0,'','.');
                                        } else {
                                            echo 'No hay informacion asociada';
                                        }  ?> <br>
        <b>Medicion de Compra: </b><?php if ($model->medicion_compra != null) {
                                        echo $model->medicion_compra;
                                    } else {
                                        echo 'No hay informacion asociada';
                                    }  ?> <br>
        <b>Numero de Importacion: </b><?php if ($model->numero_importacion != null) {
                                            echo $model->numero_importacion;
                                        } else {
                                            echo 'No hay informacion asociada';
                                        }  ?> <br>
        <b>Fecha de Importacion: </b><?php if ($model->fecha_importacion != null) {
                                            echo $model->fecha_importacion;
                                        } else {
                                            echo 'No hay informacion asociada';
                                        }  ?> <br>
    </div>
    <div class="row">
        <h2><?= "Vincular Equipos" ?> <br></h2>
        <hr>
        <b>Permite vincular Equipos: </b><?php if ($model->vehiculo_equipo == 0) {
                                                echo 'No';
                                            } else {
                                                echo 'Si';
                                            } ?> <br>
        <b>Observacion sobre la Vinculacion: </b><?php if ($model->vehiculo_equipo_observacion != null) {
                                                        echo $model->vehiculo_equipo_observacion;
                                                    } else {
                                                        echo 'No hay informacion asociada';
                                                    }  ?> <br>
    </div>
    <div><?php if (!empty($seguros)) { ?>
            <h2><?= Html::encode("Seguros del vehiculo") ?></h2>
            <table class="table table-striped table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>Nombre del seguro</th>
                        <th>Número de póliza</th>
                        <th>Valor del seguro</th>
                        <th>Fecha de vigencia</th>
                        <th>Fecha de fin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($seguros as $seguro) : ?>
                        <tr>
                            <td>
                                <?= Html::encode($seguro->tipoSeguro->nombre) ?><br>
                            </td>
                            <td>
                                <?= Html::encode($seguro->numero_poliza) ?><br>
                            </td>
                            <td>
                                <?= Html::encode('$ ' . number_format($seguro->valor_seguro, 0, '', '.')) ?><br>
                            </td>
                            <td>
                                <?= Html::encode($seguro->fecha_vigencia) ?><br>
                            </td>
                            <td>
                                <?= Html::encode($seguro->fecha_expiracion) ?><br>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <hr>

        <?php } else { ?>
            <div class="alert alert-warning">
                <strong>No hay seguros asociados</strong>
            </div>
        <?php } ?>
    </div>
    <div><?php if (!empty($documentos)) { ?>
            <h2><?= Html::encode("Documentos del vehiculo") ?></h2>
            <table class="table table-striped table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>Nombre del documento</th>
                        <th>Valor del documento</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de fin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documentos as $documento) : ?>
                        <tr>
                            <td>
                                <?= Html::encode($documento->tipoDocumento->nombre) ?><br>
                            </td>

                            <td>
                                <?= Html::encode('$ ' . number_format($documento->valor_unitario, 0, '', '.')) ?><br>
                            </td>
                            <td>
                                <?= Html::encode($documento->fecha_expedicion) ?><br>
                            </td>
                            <td>
                                <?= Html::encode($documento->fecha_expiracion) ?><br>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <hr>

        <?php } else { ?>
            <div class="alert alert-warning">
                <strong>No hay documentos asociados</strong>
            </div>
        <?php } ?>
    </div>
    <div>
        <?php if (!empty($impuestos)) { ?>
            <h2><?= Html::encode("Impuestos del vehiculo") ?></h2>
            <table class="table table-striped table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>Nombre del impuesto</th>
                        <th>Valor del impuesto</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de fin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($impuestos as $impuesto) : ?>
                        <tr>
                            <td>
                                <?= Html::encode($impuesto->tipoImpuesto->nombre) ?><br>
                            </td>

                            <td>
                                <?= Html::encode('$ ' . number_format($impuesto->valor_impuesto, 0, '', '.')) ?><br>
                            </td>
                            <td>
                                <?= Html::encode($impuesto->fecha_expedicion) ?><br>
                            </td>
                            <td>
                                <?= Html::encode($impuesto->fecha_expiracion) ?><br>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <hr>

        <?php } else { ?>
            <div class="alert alert-warning">
                <strong>No hay impuestos asociados</strong>
            </div>
        <?php } ?>
    </div>

</div>
<?php
if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}
?>