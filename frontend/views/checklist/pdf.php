<?php

use kartik\detail\DetailView;
use common\widgets\Titulo;
use kartik\grid\GridView;
use kartik\helpers\Html;
use aplicacion\models\FlujoAprobacion;
use frontend\models\CalificacionesChecklist;
use frontend\models\Checklist;
use frontend\models\ImagenesVehiculos;
use frontend\models\NovedadesChecklist;

/* @var $this yii\web\View */
/* @var $model aplicacion\models\contrato */

$this->registerCssFile("@web/css/general.css", [
    'depends' => [\frontend\assets\AppAsset::className()],
]);

$rechazadoCritico = 0;
$aprobado = 0;
$rechazado = 0;
$aprobadoPasado = 0;
$rechazadoPasado = 0;
$rechazadoCriticoPasado = 0;
$textoPasado = 'Rechazado';
$texto = 'Rechazado';

foreach ($calificacion as $estado) {

    foreach ($novedad as $nove) {
        if ($nove->calificacion0 != null) {

            if ($nove->novedad_id == $estado->novedad->id && $nove->criterioEvaluacionDet->id == $estado->valor_texto_calificacion) {
                if (strtolower($nove->calificacion0->estado) == "aprobado") {
                    $aprobado++;
                } elseif (strtolower($nove->calificacion0->estado) == "rechazado") {
                    $rechazado++;
                } elseif (strtolower($nove->calificacion0->estado) == "rechazado critico") {
                    $rechazadoCritico++;
                }
            }
        }
    }
}
$total = $aprobado + $rechazado + $rechazadoCritico;
$porcentajeAprobado = 0;
$porcentajeRechazado = 0;
$porcentajeCritico = 0;
if ($aprobado != 0) {
    $porcentajeAprobado = ($aprobado * 100) / $total;
    $porcentajeAprobado = round($porcentajeAprobado, 2);
}
if ($rechazado != 0) {
    $porcentajeRechazado = ($rechazado * 100) / $total;
    $porcentajeRechazado = round($porcentajeRechazado, 2);
}
if ($rechazadoCritico != 0) {
    $porcentajeCritico = ($rechazadoCritico * 100) / $total;
    $porcentajeCritico = round($porcentajeCritico, 2);
}


$mayor = max($porcentajeAprobado, $porcentajeRechazado, $porcentajeCritico);
//OPCIONES1
/*foreach ($estadosConfigurados as $config){
	
	if($mayor != $porcentajeCritico){
        if (($mayor == $porcentajeAprobado) && ($config->estado_checklist_id == 1) && ($rechazadoCritico <= $config->cantidad_maxima_crit) && ($porcentajeRechazado <= $config->porcentaje_maximo_rej)) {
            $texto = "Aprobado";
        } elseif (($mayor == $porcentajeRechazado) && ($rechazadoCritico <= $config->cantidad_maxima_crit) && ($porcentajeRechazado <= $config->porcentaje_maximo_rej) && ($config->estado_checklist_id == 3)) {
            $texto = "Rechazado";
        } 
    }else{
        $texto = "Rechazado/Critico";
	}
}*/

$i = 0;
foreach ($estadosConfigurados as $config) {
    $arrayEstados[$i]['rechazado'] = $config->porcentaje_maximo_rej;
    $arrayEstados[$i]['critico'] = $config->cantidad_maxima_crit;
    $i++;
}

foreach ($estadosConfigurados as $config) {
    if ($mayor != $porcentajeCritico) {
        if (($mayor == $porcentajeAprobado) && ($rechazadoCritico <= $arrayEstados[0]['critico']) && ($porcentajeRechazado <= $arrayEstados[0]['rechazado']) && ($config->estado_checklist_id == 1)) {
            $texto = "Aprobado";
        } elseif (($mayor == $porcentajeRechazado) && ($rechazadoCritico >= $arrayEstados[0]['critico']) && ($rechazadoCritico <= $arrayEstados[1]['critico']) && ($porcentajeRechazado >= $arrayEstados[0]['rechazado']) && ($porcentajeRechazado <= $arrayEstados[1]['rechazado']) && ($config->estado_checklist_id == 3)) {
            $texto = "Rechazado";
        } elseif (($rechazadoCritico >= $arrayEstados[2]['critico'])  && ($porcentajeRechazado >= $arrayEstados[2]['rechazado']) && ($config->estado_checklist_id == 3)) {
            $texto = "Rechazado/Critico";
        }
    } else {
        $texto = "Rechazado/Critico";
    }
}
/*
	if (($mayor == $porcentajeAprobado) && $porcentajeAprobado > $porcentajeRechazado && $porcentajeAprobado > $porcentajeCritico) {
		$texto = "Aprobado";
	} elseif (($mayor == $porcentajeRechazado)) {
		$texto = "Rechazado";
	} elseif (($mayor == $porcentajeCritico)) {
		$texto = "Rechazado/Critico";
	}
*/
if ($calificacionPast != 0) {
    foreach ($calificacionPast as $estado) {

        foreach ($novedad as $nove) {
            if ($nove->calificacion0 != null) {

                if ($nove->novedad_id == $estado->novedad->id && $nove->criterioEvaluacionDet->id == $estado->valor_texto_calificacion) {
                    if (strtolower($nove->calificacion0->estado) == "aprobado") {
                        $aprobadoPasado++;
                    } elseif (strtolower($nove->calificacion0->estado) == "rechazado") {
                        $rechazadoPasado++;
                    } elseif (strtolower($nove->calificacion0->estado) == "rechazado critico") {
                        $rechazadoCriticoPasado++;
                    }
                }
            }
        }
    }
    $totalPasado = $aprobadoPasado + $rechazadoPasado + $rechazadoCriticoPasado;
    $porcentajeAprobadoPasado = 0;
    $porcentajeRechazadoPasado = 0;
    $porcentajeCriticoPasado = 0;
    if ($aprobado != 0 && $totalPasado != 0) {
        $porcentajeAprobadoPasado = ($aprobadoPasado * 100) / $totalPasado;
        $porcentajeAprobadoPasado = round($porcentajeAprobadoPasado, 2);
    }
    if ($rechazadoPasado != 0 && $totalPasado != 0) {
        $porcentajeRechazadoPasado = ($rechazadoPasado * 100) / $totalPasado;
        $porcentajeRechazadoPasado = round($porcentajeRechazadoPasado, 2);
    }
    if ($rechazadoCriticoPasado != 0 && $totalPasado != 0) {
        $porcentajeCriticoPasado = ($rechazadoCriticoPasado * 100) / $totalPasado;
        $porcentajeCriticoPasado = round($porcentajeCriticoPasado, 2);
    }


    $mayorPasado = max($porcentajeAprobadoPasado, $porcentajeRechazadoPasado, $porcentajeCriticoPasado);
    //OPCIONES2
    /*foreach ($estadosConfigurados as $config) {
        if($mayorPasado== $porcentajeCriticoPasado){
            if (($mayorPasado == $porcentajeAprobadoPasado) && ($config->estado_checklist_id == 1) && ($rechazadoCriticoPasado <= $config->cantidad_maxima_crit) && ($porcentajeRechazadoPasado <= $config->porcentaje_maximo_rej)) {
                $textoPasado = "Aprobado";
            } elseif (($mayorPasado == $porcentajeRechazadoPasado) && ($rechazadoCriticoPasado <= $config->cantidad_maxima_crit) && ($porcentajeRechazadoPasado <= $config->porcentaje_maximo_rej) && ($config->estado_checklist_id == 3)) {
                $textoPasado = "Rechazado";
            }
        }else{
            $textoPasado = "Rechazado/Critico";
        }
      }*/
    foreach ($estadosConfigurados as $config) {
        if ($mayorPasado != $porcentajeCriticoPasado) {
            if (($mayorPasado == $porcentajeAprobadoPasado) && ($rechazadoCriticoPasado <= $arrayEstados[0]['critico']) && ($porcentajeRechazadoPasado <= $arrayEstados[0]['rechazado']) && ($config->estado_checklist_id == 1)) {
                $textoPasado = "Aprobado";
            } elseif (($mayorPasado == $porcentajeRechazadoPasado) && ($rechazadoCriticoPasado >= $arrayEstados[0]['critico']) && ($rechazadoCriticoPasado <= $arrayEstados[1]['critico']) && ($porcentajeRechazadoPasado >= $arrayEstados[0]['rechazado']) && ($porcentajeRechazadoPasado <= $arrayEstados[1]['rechazado']) && ($config->estado_checklist_id == 3)) {
                $textoPasado = "Rechazado";
            } elseif (($rechazadoCriticoPasado >= $arrayEstados[2]['critico'])  && ($porcentajeRechazadoPasado >= $arrayEstados[2]['rechazado']) && ($config->estado_checklist_id == 3)) {
                $textoPasado = "Rechazado/Critico";
            }
        } else {
            $textoPasado = "Rechazado/Critico";
        }
    }

    /*
	if (($mayorPasado == $porcentajeAprobadoPasado) && $porcentajeAprobadoPasado > $porcentajeRechazadoPasado && $porcentajeAprobadoPasado > $porcentajeCriticoPasado) {
		$textoPasado = "Aprobado";
	} elseif (($mayorPasado == $porcentajeRechazadoPasado)) {
		$textoPasado = "Rechazado";
	} elseif (($mayorPasado == $porcentajeCriticoPasado)) {
		$textoPasado = "Rechazado/Critico";
	}
*/
} else {
    $textoPasado = "El checklist no tiene calificacion asociada";
}



?>

<div class="container-fluid col-12">
    <div class="row">
        <h1 align="center"><?= $model->tipoChecklist->nombre ?></h1>
        <h2 align="center"><?= $model->creadoPor->name . ' ' . $model->creadoPor->surname ?></h2>
        <h2 align="center"><?= 'Vehiculo: ' . $model->vehiculo->placa ?></h2>
        <h4 align="center"><?= 'Estado del checklist: ' . $texto ?></h4>
        <p align="center"><?= "Aprobado: " . $aprobado . "(" . $porcentajeAprobado . "%)" ?></p>
        <p align="center"><?= "Rechazado: " . $rechazado . "(" . $porcentajeRechazado . "%)" ?></p>
        <p align="center"><?= "Rechazado Critico: " . $rechazadoCritico . "(" . $porcentajeCritico . "%)" ?></p>
        <p align="center"><?= "TOTAL: " . $total ?></p>
        <hr>
        <div class="row">
     
               <table style="border:0">
  <tr>
    <th> <h2><?= "Datos de la inspeccion" ?> </h2>
            <b>Fecha y Hora: </b><?= $model->fecha_checklist . " - " . $model->hora_medicion ?> <br>
            <b>Medición Siguiente Chequeo: </b><?= number_format($model->medicion_siguente, 0, '', '.') ?><br>
            <b>Medición Actual: </b><?= number_format($model->medicion_actual, 0, '', '.') ?> <br>
            <b>Tipo de Vehículo: </b><?= $model->vehiculo->tipoVehiculo->descripcion ?><br>
            <b>Conductor: </b><?= $model->usuario->name . ' ' . $model->usuario->surname ?><br>
            <b>Fecha Siguiente Chequeo: </b><?= $model->fecha_siguente ?><br>
            <b>Creado Por: </b><?= $model->creadoPor->name . ' ' . $model->creadoPor->surname ?><br></th>
    <th>                        <img width="40%" src="<?=  $imagen; ?>"   onerror="this.onerror=null; this.src=''"></th>
  </tr>
               </table>
        </div>

       
        <hr>
        <div class="row">
            <h2><?= Html::encode("Datos del vehiculo") ?></h2>
            <table class="table table-striped table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Linea Marca</th>
                        <th>Motor</th>
                        <th>Linea Motor</th>
                        <th>Medicion Actual</th>
                    </tr>
                </thead>
                <tbody class="table table-striped table-condensed">
                    <tr>
                        <td>
                            <?= Html::encode($model->vehiculo->placa) ?>
                        </td>
                        <td>
                            <?= Html::encode($model->vehiculo->marcaVehiculo->descripcion) ?>
                        </td>
                        <td>
                            <?= Html::encode($model->vehiculo->lineaVehiculo->descripcion) ?>
                        </td>
                        <td>
                            <?= Html::encode($model->vehiculo->motor->nombre) ?>
                        </td>
                        <td>
                            <?= Html::encode($model->vehiculo->lineaMotor->descripcion) ?>
                        </td>
                        <td>
                            <?= number_format($model->medicion_actual, 0, '', '.') ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <?php if (is_object($checklist)) { ?>
            <h2><?= Html::encode("Datos de los checklist anteriores") ?></h2>
            <table class="table table-striped table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Fecha y hora</th>
                        <th>Medición</th>
                        <th>Ver calificación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?= Html::encode($checklist->id) ?><br>
                        </td>
                        <td>
                            <?= Html::encode($checklist->fecha_checklist . ' - ' . $checklist->hora_medicion) ?><br>
                        </td>
                        <td>
                            <?= Html::encode(number_format($checklist->medicion_actual, 0, '', '.')) ?><br>
                        </td>
                        <td class="text-center">
                            <?= Html::encode($textoPasado) ?><br>
                        </td>
                    </tr>

                </tbody>
            </table>
        <?php } else { ?>
            <h2><?= Html::encode("Checklist anteriores") ?></h2>
            <b><?= Html::encode("No hay un checklist anterior a este.") ?></b>
        <?php } ?>
        <hr>
        <?php if (!empty($calificacion)) { ?>
            <h2><?= Html::encode("Calificacion de novedades") ?></h2>
            <table class="table table-striped table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>
                            Grupo de la novedad
                        </th>
                        <th>
                            Novedad
                        </th>
                        <th>
                            Criterio
                        </th>
                        <th>
                            Calificación
                        </th>
                    </tr>
                </thead>
                <?php foreach ($calificacion as $calif) : ?>
                    <tr>
                        <td>
                            <?= Html::encode($calif->grupoNovedad->nombre) ?><br>
                        </td>
                        <td>
                            <?= Html::encode($calif->novedad->nombre) ?><br>
                        </td>
                        <td>
                            <?= Html::encode($calif->criterioCalificacion->nombre) ?><br>
                        </td>
                        <td>

                            <?php
                            if (strtolower($calif->criterioCalificacion->nombre) == 'nivel') {
                                $detalle = $calif->valor_texto_editable;
                                $var = 1;
                            } else {
                                $detalle = $calif->detalle->detalle;
                                $var = 0;
                            }
                            foreach ($novedad as $nove) {
                                if ($nove->calificacion0 != null) {
                                    if ($nove->novedad_id == $calif->novedad->id && $nove->criterioEvaluacionDet->id == $calif->valor_texto_calificacion) {
                                        if (strtolower($nove->calificacion0->estado) == "aprobado") {
                                            echo $detalle . ' - ' . '<label class="label label-success">Aprobado</label>';
                                        } elseif (strtolower($nove->calificacion0->estado) == "rechazado") {
                                            echo $detalle . ' - ' . '<label class="label label-warning">Rechazado</label>';
                                        } elseif (strtolower($nove->calificacion0->estado) == "rechazado critico") {
                                            echo $detalle . ' - ' . '<label class="label label-danger">Rechazado Critico</label>';
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php } else { ?>
            <h2><?= Html::encode("Calificacion de novedades") ?></h2>
            <b><?= Html::encode("No hay calificaciones para mostrar.") ?></b>
        <?php } ?>
        <hr>

        <?php if (!empty($seguros)) : ?>
            <h2><?= Html::encode("Seguros del vehiculo") ?></h2>
            <table class="table table-striped table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>Nombre del seguro</th>
                        <th>Número de póliza</th>
                        <th>Valor del seguro</th>
                        <th>Fecha de vigencia</th>
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <hr>

        <?php endif; ?>

    </div>

</div>





<?php
if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}
?>