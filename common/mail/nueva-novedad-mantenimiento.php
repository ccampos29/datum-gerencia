<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
   Se ha creado una nueva novedad de mantimiento. El trabajo a realizar es: <?= $model->trabajo->nombre ?>, para el vehículo <?= $model->vehiculo->placa; ?>.
</div>

<br><br>
Atentamente,
<br>
<br>
Sistema de notificaciones de DATUM
<br>
<br>
<strong>Esta es una notificación automática, por favor no responda este mensaje</strong>