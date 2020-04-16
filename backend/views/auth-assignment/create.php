<?php

use common\widgets\Titulo;

/**
 * @var yii\web\View $this
 * @var administracion\models\AuthAssignment $model
 */

$this->title = 'Asignar rol/permiso a usuario';
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Utilidades';
$this->params['breadcrumbs'][] = ['label' => 'Permisos VS Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-create">

    <?php
        echo Titulo::widget([
            'tipo' => Titulo::TIPO_PRINCIPAL,
            'titulo' => $this->title]); 
    ?>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
