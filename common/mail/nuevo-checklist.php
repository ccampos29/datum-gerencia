<?php

use yii\helpers\Html;
use frontend\models\NovedadesChecklist;
use frontend\models\Checklist;
use frontend\models\VehiculosSeguros;
use frontend\models\CalificacionesChecklist;
use frontend\models\EstadosChecklistConfiguracion;

/* @var $this yii\web\View */
/* @var $model id Checklist */

$calificacion = CalificacionesChecklist::find()->where(['checklist_id' => $model->id])->all();
$novedad = NovedadesChecklist::find()->all();
$estadosConfigurados = EstadosChecklistConfiguracion::find()->where(['tipo_checklist_id' => $model->tipo_checklist_id])->all();
$rechazadoCritico = 0;
$aprobado = 0;
$rechazado = 0;
$var = 0;
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

$i=0;
foreach ($estadosConfigurados as $config) {
    $arrayEstados[$i]['rechazado'] = $config->porcentaje_maximo_rej;
    $arrayEstados[$i]['critico'] = $config->cantidad_maxima_crit;
	$i++;
}

foreach ($estadosConfigurados as $config) {
	if($mayor != $porcentajeCritico){
		if (($mayor == $porcentajeAprobado) && ($rechazadoCritico <= $arrayEstados[0]['critico']) && ($porcentajeRechazado <= $arrayEstados[0]['rechazado']) && ($config->estado_checklist_id == 1)) {
			$texto = "Aprobado";
		} elseif (($mayor == $porcentajeRechazado) && ($rechazadoCritico >= $arrayEstados[0]['critico']) && ($rechazadoCritico <= $arrayEstados[1]['critico']) && ($porcentajeRechazado >= $arrayEstados[0]['rechazado']) && ($porcentajeRechazado <= $arrayEstados[1]['rechazado']) && ($config->estado_checklist_id == 3)) {
			$texto = "Rechazado";
		}elseif (($rechazadoCritico >= $arrayEstados[2]['critico'])  && ($porcentajeRechazado >= $arrayEstados[2]['rechazado']) && ($config->estado_checklist_id == 3)) {
			$texto = "Rechazado/Critico";
		}
	} else{
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





$checklist = Checklist::find()->where(['vehiculo_id' => $model->vehiculo->id])->all();
if ($model->id > 1) {
  foreach ($checklist as $check) {

    $array[] = $check->id;
    if ($check->id == $model->id) {
      try {
        $var = $array[count($array) - 2];
      } catch (Exception $ex) {
        $var = 0;
      }
    }
  }
}

if ($var > 0) {
  $checklistPast = Checklist::findOne((int) $var);
  $calificacionPast = CalificacionesChecklist::find()->where(['checklist_id' => $checklistPast->id])->all();
  foreach ($calificacionPast as $estado) {
    foreach ($novedad as $nove) {
      if ($nove->criterioEvaluacionDet != null && $nove->calificacion0 != null) {
        if ((int) $nove->criterioEvaluacionDet->id == $estado->valor_texto_calificacion) {
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

    if($mayorPasado != $porcentajeCriticoPasado){
      if (($mayorPasado == $porcentajeAprobadoPasado) && ($config->estado_checklist_id == 1) && ($rechazadoCriticoPasado <= $config->cantidad_maxima_crit) && ($porcentajeRechazadoPasado <= $config->porcentaje_maximo_rej)) {
        $textoPasado = "Aprobado";
      } elseif (($mayorPasado == $porcentajeRechazadoPasado) && ($rechazadoCriticoPasado <= $config->cantidad_maxima_crit) && ($porcentajeRechazadoPasado <= $config->porcentaje_maximo_rej) && ($config->estado_checklist_id == 3)) {
        $textoPasado = "Rechazado";
      } elseif (($mayorPasado == $porcentajeCriticoPasado) && ($rechazadoCriticoPasado >= $config->cantidad_maxima_crit) && ($porcentajeRechazadoPasado <= $config->porcentaje_maximo_rej) && ($config->estado_checklist_id == 4)) {
        $textoPasado = "Rechazado/Critico";
      }
    }else{
      $textoPasado = "Rechazado/Critico";
    }
  }*/
  foreach ($estadosConfigurados as $config) {
    if($mayorPasado != $porcentajeCriticoPasado){
        if (($mayorPasado == $porcentajeAprobadoPasado) && ($rechazadoCriticoPasado <= $arrayEstados[0]['critico']) && ($porcentajeRechazadoPasado <= $arrayEstados[0]['rechazado']) && ($config->estado_checklist_id == 1)) {
            $textoPasado = "Aprobado";
        } elseif (($mayorPasado == $porcentajeRechazadoPasado) && ($rechazadoCriticoPasado >= $arrayEstados[0]['critico']) && ($rechazadoCriticoPasado <= $arrayEstados[1]['critico']) && ($porcentajeRechazadoPasado >= $arrayEstados[0]['rechazado']) && ($porcentajeRechazadoPasado <= $arrayEstados[1]['rechazado']) && ($config->estado_checklist_id == 3)) {
            $textoPasado = "Rechazado";
        }elseif (($rechazadoCriticoPasado >= $arrayEstados[2]['critico'])  && ($porcentajeRechazadoPasado >= $arrayEstados[2]['rechazado']) && ($config->estado_checklist_id == 3)) {
            $textoPasado = "Rechazado/Critico";
        }
    } else{
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
}
$seguros = VehiculosSeguros::find()->where(['vehiculo_id' => $model->vehiculo->id])->all();
?>
<div class="checklist-calificacion">
  <div class="container-fluid col-12">
    <div class="row">
      <center>
        <h1><?= Html::encode($model->tipoChecklist->nombre) ?></h1>
        <h2><?= Html::encode($model->creadoPor->name . ' ' . $model->creadoPor->surname) ?></h2>
        <h2><?= Html::encode('Vehiculo: ' . $model->vehiculo->placa) ?></h2>
        <h4><?= Html::encode('Estado del checklist: ' . $texto) ?></h4>
        <p><b><?= Html::encode("Aprobado: " . $aprobado . "(" . $porcentajeAprobado . "%)") ?></b></p>
        <p><b><?= Html::encode("Rechazado: " . $rechazado . "(" . $porcentajeRechazado . "%)") ?></b></p>
        <p><b><?= Html::encode("Rechazado Critico: " . $rechazadoCritico . "(" . $porcentajeCritico . "%)") ?></b></p>
        <p><b><?= Html::encode("TOTAL: " . $total) ?></b></p>

      </center>
      <hr>

      <table class="table table-striped table-condensed" width='100%'>
        <h2><?= Html::encode("Datos de la inspeccion") ?> </h2>
        <tr>
          <td>
            <b>Fecha y Hora: </b><?= Html::encode($model->fecha_checklist . " - " . $model->hora_medicion) ?><br>
          </td>
          <td>
            <b>Medición Siguiente Chequeo: </b><?= Html::encode(number_format($model->medicion_siguente, 0, '', '.')) ?><br>
          </td>
        </tr>
        <tr>
          <td>
            <b>Medición Actual: </b><?= Html::encode(number_format($model->medicion_actual, 0, '', '.')) ?><br>
          </td>
          <td>
            <b>Tipo de Vehículo: </b><?= Html::encode($model->vehiculo->tipoVehiculo->descripcion) ?><br>
          </td>
        </tr>
        <tr>
          <td>
            <b>Conductor: </b><?= Html::encode($model->usuario->name . ' ' . $model->usuario->surname) ?><br>
          </td>
          <td>
            <b>Fecha Siguiente Chequeo: </b><?= Html::encode($model->fecha_siguente) ?><br>
          </td>
        </tr>
        <tr>
          <td>
            <b>Creado Por: </b><?= Html::encode($model->creadoPor->name . ' ' . $model->creadoPor->surname) ?><br>
          </td>
        </tr>


      </table>

      <hr>
      <table class="table table-striped table-condensed" width="100%">
        <h2><?= Html::encode("Datos del vehiculo") ?></h2>
        <tr>
          <td>
            <b>Placa: </b><?= Html::encode($model->vehiculo->placa) ?><br>
          </td>
          <td>
            <b>Marca: </b><?= Html::encode($model->vehiculo->marcaVehiculo->descripcion) ?><br>
          </td>
        </tr>
        <tr>
          <td>
            <b>Línea: </b><?= Html::encode($model->vehiculo->lineaVehiculo->descripcion) ?><br>
          </td>
          <td>
            <b>Motor: </b><?= Html::encode('Marca: ' . $model->vehiculo->motor->nombre . ' - Linea: ' . $model->vehiculo->lineaMotor->descripcion) ?><br>
          </td>
        </tr>
        <tr>
          <td>
            <b>Medición Actual: </b><?= number_format($model->medicion_actual, 0, '', '.') ?><br>
          </td>
        </tr>
      </table>
      <hr>
      <?php if ($var > 0) { ?>
        <h2><?= Html::encode("Datos de los checklist anteriores") ?></h2>
        <table class="table table-striped table-condensed" width="100%">
          <thead>
            <tr>
              <th>Número</th>
              <th>Fecha y hora</th>
              <th>Medición</th>
              <th>Calificación</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <?= Html::encode(Checklist::findOne($var)->consecutivo) ?><br>
              </td>
              <td>
                <?= Html::encode(Checklist::findOne($var)->fecha_checklist . ' - ' . Checklist::findOne($var)->hora_medicion) ?><br>
              </td>
              <td>
                <?= Html::encode(number_format(Checklist::findOne($var)->medicion_actual, 0, '', '.')) ?><br>
              </td>
              <td class="text-center">
                <?= Html::encode($textoPasado) ?><br>
              </td>
            </tr>

          </tbody>
        </table>
      <?php

      } else { ?>
        <table class="table table-striped table-condensed" width="100%">
          <h2><?= Html::encode("Datos del checklist anterior") ?></h2>
          <b><?= Html::encode("No hay datos para mostrar"); ?></b>
        </table>
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
          <?php foreach ($calificacion as $calif) { ?>
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
                $novedad = NovedadesChecklist::find()->where(['novedad_id' => $calif->novedad_id])->all();

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
          <?php } ?>
        </table>
      <?php } else { ?>
        <table class="table table-striped table-condensed" width="100%">
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
</div>
<br><br>
Atentamente,
<br>
<br>
Sistema de notificaciones de DATUM
<br>
<br>
<strong>Esta es una notificación automática, por favor no responda este mensaje</strong>