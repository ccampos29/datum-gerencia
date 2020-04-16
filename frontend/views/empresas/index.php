<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\JsExpression;
use yii\helpers\Url;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EmpresasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empresas';
$this->params['breadcrumbs'][] = $this->title;


//$usuarioPrincipal= empty($searchModel->usuario_principal_id) ? '' : User::find()->where(['empresa_id' => $searchModel->empresa_id,'es_administrador_empresa' => 1])->one();
$url = Url::to(['user/usuarios-list']);
?>
<div class="empresas-index">

    <p>
        <?= Html::a('Crear empresa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'nombre',
                'nit_identificacion',
                'digito_verificacion',
                'numero_celular',
                'fecha_inicio_licencia',
                'fecha_fin_licencia',
                [
                    'label' => 'Usuario administrador',
                    'attribute' => 'usuario_principal_id',
                    'value' => function ($data) {
                        return ($data->usuario_principal_id)?$data->usuarioPrincipal->name . ' ' . $data->usuarioPrincipal->surname: 'No definido';
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => 'Buscar un usuario ...'],
                        //'initValueText' => $usuarioPrincipal->name.' '.$usuarioPrincipal->surname,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 1,
                            'language' => [
                                'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                            ],
                            'ajax' => [
                                'url' => $url,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ],
                    'filterInputOptions' => ['placeholder' => ''],
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    ?>


</div>