<?php

use common\widgets\Titulo;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Crear';
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Parametrización básica';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?php
    echo $this->render('_form', [
        'model' => $model,
        'user' => (isset($user))? $user:''
    ])
    ?>

</div>
