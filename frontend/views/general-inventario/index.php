<?php

use frontend\models\UbicacionesInsumos;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\GeneralInventarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configuración General de Inventarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="general-inventario-index">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?php
            $data = ArrayHelper::map(UbicacionesInsumos::find()->all(), 'id', 'nombre');
            echo $form->field($model, 'ubicacion_insumo_id')->widget(Select2::classname(), [
                'data' => $data,
                'options' => ['placeholder' => 'Seleccione un grupo de novedad...'],
                'pluginOptions' => [

                    'tokenSeparators' => [',', ' ']
                ],
            ])
            ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'descarga_respuestos')->dropDownList(
                ['0' => 'No', '1' => 'Si'],
                [
                    'prompt' => 'Seleccione una opción...',

                ]
            ) ?>
        </div>
    </div>

</div>


<div class="form-group">
<?= Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id . '/']), ['class' => 'btn btn-default']); ?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
</div>

<?php ActiveForm::end(); ?>



</div>