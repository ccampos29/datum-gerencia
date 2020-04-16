<?php

use kartik\detail\DetailView;
use common\widgets\Titulo;

/**
 * @var yii\web\View $this
 * @var administracion\models\AuthItem $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Parametrización avanzada';
$this->params['breadcrumbs'][] = ['label' => 'Roles y permisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-view">

    <?php
        echo Titulo::widget([
            'tipo' => Titulo::TIPO_PRINCIPAL,
            'titulo' => $this->title]); 
    ?>

    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>FALSE,
            'hover'=>TRUE,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_PRIMARY,
        ],
        'attributes' => [
            'name',
            [
                'attribute' => 'type',
                'value' => $model->tipoTexto,
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => \backend\models\AuthItem::arrayTipo(),
                ],
            ],
        'description:ntext',
        ],
        'deleteOptions'=>[
            'url'=>['delete', 'id' => $model->name],
            'confirm'=>'Seguro que quiere borrar este Rol/Permiso y todo lo que depende de él',
        ],
        'enableEditMode'=>TRUE,
    ]) ?>

</div>
