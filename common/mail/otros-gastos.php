<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<table class="table table-striped table-condensed" width='100%'>
        <h2><?= Html::encode("Datos de la inspeccion") ?> </h2>
        <tr>
          <td>
            <b>Placa: </b><?= Html::encode($model->vehiculo->placa) ?><br>
          </td>
          <td>
            <b>Tipo del Gasto: </b><?= Html::encode($model->tipoGasto->nombre) ?><br>
          </td>
        </tr>
        <tr>
          <td>
            <b>Fecha del gasto: </b><?= Html::encode($model->fecha) ?><br>
          </td>
          <td>
            <b>Impuesto sobre el Gasto: </b><?= Html::encode($model->tipoImpuesto->nombre) ?><br>
          </td>
        </tr>
        <tr>
          <td>
            <b>Valor Unitario: </b><?= Html::encode($model->valor_unitario) ?><br>
          </td>
          <td>
            <b>Cantidad Unitaria: </b><?= Html::encode($model->cantidad_unitaria) ?><br>
          </td>
        </tr>
        <tr>
          <td>
            <b>Tipo de Descuento: </b><?php if($model->tipo_descuento== 1) {
                            echo Html::encode ('%');
                }else{
                   echo Html::encode( '$');
                    
                }?><br>
          </td>
        </tr>
        <tr>
          <td>
            <b>Cantidad Descuento: </b><?= Html::encode($model->cantidad_descuento) ?><br>
          </td>
        </tr>
        <tr>
          <td>
            <b>Total: </b><?php 
            if($model->cantidad_unitaria>0){
                if(strtolower($model->tipoImpuesto->nombre)=='iva incluido'){
                    $value = (($model->valor_unitario*$model->cantidad_unitaria))-(($model->valor_unitario*$model->cantidad_unitaria)*($model->cantidad_descuento/100))*(1.19);
                   
                }else{
                    $value = (($model->valor_unitario*$model->cantidad_unitaria))-(($model->valor_unitario*$model->cantidad_unitaria)*($model->cantidad_descuento/100));
                }
            }else{
                if(strtolower($model->tipoImpuesto->nombre)=='iva incluido'){
                    $value = (($model->valor_unitario))-(($model->valor_unitario)*($model->cantidad_descuento/100))*(1.19);
                   
                }else{
                    $value = (($model->valor_unitario))-(($model->valor_unitario)*($model->cantidad_descuento/100));
                }
                    
            }
            
            echo Html::encode( number_format($value, 0, '', '.'))?><br>
          </td>
        </tr>


      </table>

<div>
    Por Favor Ingrese a Datum Gerencia para revisar la situacion y tomar las acciones necesarias.
</div>

<br><br>
Atentamente,
<br>
<br>
Sistema de notificaciones de DATUM
<br>
<br>
<strong>Esta es una notificación automática, por favor no responda este mensaje</strong>