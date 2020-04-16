<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
    Recuerde que el próximo <?= $model->fecha_hora_cierre; ?>, se vence la orden de trabajo <?= $model->id ?> del vehículo <?= $model->vehiculo->placa ?>.
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