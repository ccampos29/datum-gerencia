<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
   La empresa <strong><?= $model->nombre ?></strong> ha sido creada en el sistema <strong>DATUM GERENCÍA</strong>,
   se ha enviado un correo electrónico al usuario administrador de este perfil para que active su cuenta y pueda dar inicio
   a la utilidad del sistema.
    <br>
   La licencia adquirida tiene la siguiente vigencia:
    <br>
   Fecha inicio: <?= $model->fecha_inicio_licencia ?>
   <br>
   Fecha fin: <?= $model->fecha_fin_licencia ?>
</div>

<br><br>
Atentamente,
<br>
<br>
Sistema de notificaciones de DATUM
<br>
<br>
<strong>Esta es una notificación automática, por favor no responda este mensaje</strong>