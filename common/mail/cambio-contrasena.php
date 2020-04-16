<?php

use yii\helpers\Html;
use yii\helpers\Url;


$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div>
    <p>
        Hola <?= Html::encode($user->username) ?>, para cambiar la contraseña debe dar clic en el siguiente enlace.
    </p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>

<br><br>
Atentamente,
<br>
<br>
Sistema de notificaciones de DATUM
<br>
<br>
<strong>Esta es una notificación automática, por favor no responda este mensaje</strong>