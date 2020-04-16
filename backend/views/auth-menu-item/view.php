<?php

use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use common\widgets\Titulo;
use backend\models\AuthItem;
use common\models\AuthMenuItem;

/**
 * @var yii\web\View $this
 * @var common\models\AuthMenuItem $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Parametrización avanzada';
$this->params['breadcrumbs'][] = ['label' => 'Menús', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-menu-item-view">

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
            'label',

            [
                'attribute' => 'auth_item',
                'value' => $model->auth_item,
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => ArrayHelper::map(AuthItem::find()->orderBy('name')
                                ->asArray()->all(), 'name', 'name'),
                ],
            ],            
            
            [
                'attribute' => 'tipo',
                'value' => $model->tipo,
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => Yii::$app->ayudante->datosEnum('auth_menu_item', 'tipo'),
                ],
            ],
            
            [
                'attribute' => 'visible',
                'value' => $model->visible ? "Si" : "No",
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => Yii::$app->ayudante->booleanArray(),
                ],
            ],            
            
            [
                'attribute' => 'padre',
                'value' => $model->menuPadre->name,
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => ArrayHelper::map(AuthMenuItem::find()->orderBy('name')
                                ->asArray()->all(), 'id', 'name'),
                ],
            ],            
            
            'orden',
            'ruta',
            'icono',
            
            [
                'attribute' => 'separador',
                'value' => $model->separador ? "Si" : "No",
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => Yii::$app->ayudante->booleanArray(),
                ],
            ], 
            
            'descripcion:ntext',
        ],
        'deleteOptions'=>[
            'url'=>['delete', 'id' => $model->id],
            'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
            'data'=>[
                'method'=>'post',
            ],
        ],
        'enableEditMode'=>TRUE,
    ]) ?>

</div>
