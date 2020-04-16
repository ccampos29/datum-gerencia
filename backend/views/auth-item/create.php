<?php

use common\widgets\Titulo;

/**
 * @var yii\web\View $this
 * @var administracion\models\AuthItem $model
 */

$this->title = 'Crear rol o permiso';
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Parametrización avanzada';
$this->params['breadcrumbs'][] = ['label' => 'Roles y permisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <?php
    echo Titulo::widget([
        'tipo' => Titulo::TIPO_PRINCIPAL,
        'titulo' => $this->title]); 
    
    echo $this->render('_form', [
            'model' => $model,
    ]); ?>

</div>
