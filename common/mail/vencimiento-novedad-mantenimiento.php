<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
    La novedad de mantenimiento <?= $model->id;?>, para el vehículo <?= $model->vehiculo->placa ?> tiene una fecha de solución el próximo <?= $model->fecha_solucion; ?>. Prioridad <?= $model->prioridad->nombre; ?>.
    <br>
    Por favor ingrese a Datum Gerencia para revisar esta situación y tomar acciones necesarias.
</div>
<br><br>
Atentamente,
<br>
<br>
Sistema de notificaciones de DATUM
<br>
<br>
<strong>Esta es una notificación automática, por favor no responda este mensaje</strong>