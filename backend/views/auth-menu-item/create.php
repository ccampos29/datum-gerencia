<?php

use common\widgets\Titulo;

/**
 * @var yii\web\View $this
 * @var common\models\AuthMenuItem $model
 */

$this->title = 'Crear menú';
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Parametrización avanzada';
$this->params['breadcrumbs'][] = ['label' => 'Menús', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-menu-item-create">

    <?php
        echo Titulo::widget([
            'tipo' => Titulo::TIPO_PRINCIPAL,
            'titulo' => $this->title]); ?>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
