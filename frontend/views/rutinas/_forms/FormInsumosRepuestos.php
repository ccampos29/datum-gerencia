<?php

use frontend\models\Repuestos;
use frontend\models\RutinasTrabajos;
use unclead\multipleinput\MultipleInput;
use yii\helpers\ArrayHelper;
use frontend\models\Trabajos;
use yii\helpers\Url;
use unclead\multipleinput\MultipleInputColumn;
use kartik\form\ActiveForm;
use kartik\helpers\Html;

$this->title = 'Asociar insumos y repuestos';
$this->params['breadcrumbs'][] = ['label' => 'Rutinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// print_r($arrayTrabajos);
$form = ActiveForm::begin([
    'action' => Yii::$app->urlManager->createUrl([
        'rutinas/asociar-insumos-repuestos',
        'idRutina' => $model->id,
    ])
]);
?>

<?= $form->field($model, 'repuestos')->widget(MultipleInput::className(), [
    'addButtonPosition' => MultipleInput::POS_FOOTER,
    'allowEmptyList' => false,
    'id' => 'select_to',

    'columns' => [
        [
            'name' => 'id',
            'options' => [
                'class' => 'hidden',
            ],
        ],
        [
            'name'  => 'rutina_trabajo_id',
            'type'  => \kartik\select2\Select2::className(),
            'title' => 'Trabajo',
            'enableError' => true,
            'options' => [
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'options' => [
                    'placeholder' => 'Seleccione...',
                ],
                'data' => $arrayTrabajos,
            ],
        ],
        [
            'name'  => 'inventariable',
            'type'  => MultipleInputColumn::TYPE_DROPDOWN,
            'title' => 'Proviene de',
            'enableError' => true,
            'items' => [0 => 'Proveedor', 1 => 'Inventario'],
            'options' => [
                'id' => 'idInventariable-{multiple_index_select_to}',
            ],
        ],
        [
            'name'  => 'repuesto',
            'type'  => \kartik\depdrop\DepDrop::className(),
            'title' => 'Repuestos',
            'enableError' => true,
            // 'value' => function($data){
            //     $resultado = !empty($data['repuesto_id']) ? [$data['repuesto_id'] => Repuestos::findOne($data['repuesto_id'])->nombre] : [];
            //     return 'asdasd';
            // },
            'options' => [
                'id' => 'idRepuesto',
                // 'data' => function($data){
                //     return $data['repuesto_id'];
                // },
                'pluginOptions' => [
                    'depends' => ['idInventariable-{multiple_index_select_to}'], // !!!! NOT replaced
                    'placeholder' => 'Select...',
                    'url' => Url::to(['/rutinas/repuestos']),
                ],
            ],
        ],
        [
            'name'  => 'cantidad',
            'title' => 'Cantidad',
            'enableError' => true,
            'options' => [
                'class' => 'input-priority campo-cantidad'
            ]
        ],
        [
            'name'  => 'valor',
            'title' => 'Valor',
            'enableError' => true,
            'options' => [
                'class' => 'input-priority',
                'disabled' => true,
            ]
        ],
    ]
])->label(false)
?>

<div>
    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['rutinas/update', 'id' => $model->id]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver a la rutina </a>
    </div>
    <div class="form-group pull-right">
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar insumos y repuestos', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php
ActiveForm::end();

$this->registerJsFile(
    '@web/js/rutinasTrabajos.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>