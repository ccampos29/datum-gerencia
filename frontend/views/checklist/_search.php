<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use frontend\models\Vehiculos;
use frontend\models\User;
use kartik\depdrop\DepDrop;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\Checklist */
/* @var $form yii\widgets\ActiveForm */

$urlVehiculos = Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list');
$urlUsuarios = Yii::$app->urlManager->createUrl('user/tipos-usuarios-list');

/* @var $this yii\web\View */
/* @var $model frontend\models\ChecklistSearch */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Consultas Checklist';

?>
<style>
    .save {
        display: none;
    }
</style>
<?php Pjax::begin(['enablePushState'=>false]); ?>

<div class="checklist-search">

    <?php $form = ActiveForm::begin([
        'action' => ['consulta'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="container-fluid col-12">
        <div class="row">

            <div class="col-sm-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha del checklist
                </label>
                <?= DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'fecha_checklist_1',
                    'attribute2' => 'fecha_checklist_2',
                    'options' => ['placeholder' => 'Fecha Inicial'],
                    'options2' => ['placeholder' => 'Fecha Final'],
                    'type' => DatePicker::TYPE_RANGE,
                    'form' => $form,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ]); ?>
            </div>
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-cubes" aria-hidden="true"></i> Vehiculo
                </label>
                <?= $form->field($model, 'vehiculo_id')->widget(Select2::classname(), [
                    'data' => !empty($model->vehiculo_id) ? [$model->vehiculo_id => Vehiculos::findOne($model->vehiculo_id)->placa] : [],
                    'options' => ['id' => 'select-placa'],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un vehículo',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => $urlVehiculos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false)
                ?>
            </div>
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-car" aria-hidden="true"></i> Tipo del Checklist
                </label>
                <?= $form->field($model, 'tipo_checklist_id')->widget(DepDrop::classname(), [
                    'options' => ['id' => 'idTipoChecklist'],
                    'pluginOptions' => [
                        'depends' => ['select-placa'],
                        'placeholder' => 'Select...',
                        'url' => Url::to(['tipos-checklist/tipo'])
                    ]
                ])->label(false) ?>
            </div>


        </div>

        <div class="row">
            
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha del siguiente checklist
                </label>
                <?= DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'fecha_siguente_1',
                    'attribute2' => 'fecha_siguente_2',
                    'options' => ['placeholder' => 'Fecha Inicial'],
                    'options2' => ['placeholder' => 'Fecha Final'],
                    'type' => DatePicker::TYPE_RANGE,
                    'form' => $form,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ]); ?>
            </div>
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Conductor
                </label>
                <?= $form->field($model, 'usuario_id')->widget(Select2::classname(), [
                    'data' => !empty($model->usuario_id) ? [$model->usuario_id => User::findOne($model->usuario_id)->name] : [],
                    'pluginOptions' => [
                        'placeholder'=>'Seleccione un conductor',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => $urlUsuarios,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false)
                ?>
            </div>
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-check" aria-hidden="true"></i> Calificacion
                </label>
                <?= $form->field($model, 'estado')->widget(Select2::classname(), [
                    'data' => [
                        'Aprobado' => 'Aprobado',
                        'Rechazado' => 'Rechazado',
                        'Rechazado/Critico' => 'Rechazado/Critico'
                    ],
                    'pluginOptions' => [
                        'placeholder'=>'Seleccione un conductor',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                    ]
                ])->label(false)
                ?>
            </div>
        </div>


        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success save']) ?>
        </div>



        <div class="row">
            <div class="col-md-12 text-center">

                <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i>  Buscar', ['class' => 'btn btn-primary']) ?>

                <?= Html::resetButton('<i class="fa fa-refresh" aria-hidden="true"></i> Limpiar', ['class' => 'btn btn-outline-secondary']) ?>


            </div>
        </div>

        <?php ActiveForm::end();
        $this->registerJsFile(
            '@web/js/checklistWebService.js',
            ['depends' => [\yii\web\JqueryAsset::className()]]
        );
        ?>

        <div class="row" style="margin-top:40px;">
            <div class="col-sm-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                   // 'filterModel' => $searchModel,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> Consulta de Checklist</h3>',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['label' => 'Vehículos',
                        'attribute'=>'vehiculo_id',
                        'value' => 'vehiculo.placa'],
                        'medicion_actual',
                  
                        ['label' => 'Tipo Checklist',
                        'attribute'=>'tipo_checklist_id',
                        'value' => 'tipoChecklist.nombre'],
                        'fecha_checklist',
                        'fecha_siguente',
                        'hora_medicion',
                        [
                            'label' => 'Conductor',
                            'attribute' => 'usuario_id',
                            'value' => 'usuario.name'
                        ],
                        [
                            'label' => 'Elaborado Por',
                            'attribute' => 'usuario_id',
                            'value' => 'creadoPor.name'
                        ],
                        'estado',                        
                    ],
                    'export' => [
                        'label' => 'Descargar',
                    ],
                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta Checklist',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>

    </div>
</div>
<?php Pjax::end(); ?>
