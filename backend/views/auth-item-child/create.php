<?php

use common\widgets\Titulo;

/**
 * @var yii\web\View $this
 * @var administracion\models\AuthItemChild $model
 */

$this->title = 'Crear rama de permisos';
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Parametrización avanzada';
$this->params['breadcrumbs'][] = ['label' => 'Jerarquía permisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-create">

    <?= Titulo::widget([
        'tipo' => Titulo::TIPO_PRINCIPAL,
        'titulo' => $this->title]); 
    ?>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
