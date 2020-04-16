<?php

use yii\helpers\Html;
use yii\helpers\Url;


$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div>
    <p>
        Hola <?= Html::encode($user->username) ?>, se ha creado la empresa <?= $empresa->nombre ?> donde usted
        es el administrador, para activar la cuenta y poder ingresar al sistema <strong>DATUM GERENCIA</strong> debe dar
        clic en el siguiente enlace.
    </p>
    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>

<br><br>
Atentamente,
<br>
<br>
Sistema de notificaciones de DATUM
<br>
<br>
<strong>Esta es una notificación automática, por favor no responda este mensaje</strong>