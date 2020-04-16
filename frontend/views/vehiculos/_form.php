<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\Vehiculos */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="vehiculos-form">
    
    <?php $form = ActiveForm::begin([

        'enableClientValidation' => false,

        'enableAjaxValidation' => false

        ]); 
    ?>
    <?= TabsX::widget([
        'items' => [
            [
                'label' => 'Datos Basicos',
                'content' => $this->render('forms/FormDatosBasicos', ['model' => $model, 'form' => $form]),
                'active' => true
            ],
            [
                'label' => 'Uso del Vehiculo',
                'content' => $this->render('forms/FormUsoVehiculo', ['model' => $model, 'form' => $form]),
            ],
            [
                'label' => 'Datos de Agrupacion',
                'content' => $this->render('forms/FormDatosAgrupacion', ['model' => $model, 'form' => $form]),
            ],
            [
                'label' => 'Mas Datos',
                'content' => $this->render('forms/FormMasDatos', ['model' => $model, 'form' => $form]),
            ],
            [
                'label' => 'Compra',
                'content' => $this->render('forms/FormCompra', ['model' => $model, 'form' => $form]),
            ],
            [
                'label' => 'Vincular Equipos',
                'content' => $this->render('forms/FormVincularEquipos', ['model' => $model, 'form' => $form]),
            ],
            
        ]]);
    ?>
    

    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
        <div class="form-group-pull-right">
            <button type="submit" class="flotante"><i class="fa fa-floppy-o"></i>
                
            </button>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
