<?php

namespace common\widgets;

use \yii\bootstrap\Widget;
use yii\helpers\Html;

/**
 * Widget que permite añadir diferentes tipos de botones en las vistas.
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class Boton extends Widget{
    const TIPO_ENVIAR_CANCELAR = 'enviar';
    const TIPO_AYUDA = 'ayuda';
    
    /**
     * Tipo de botón a crear
     * @var string 
     */
    public $tipo; 
    
    /**
     * Texto que tendrá el botón submit en los botones TIPO_ENVIAR_CANCELAR
     * @var string 
     */
    public $etiquetaEnviar; 
    
    /**
     * Texto que tendrá el botón cancelar en los botones TIPO_ENVIAR_CANCELAR
     * @var string 
     */
    public $etiquetaCancelar; 
    
    /**
     * URL para el hipervínculo del botón cancelar 
     * @var array | string 
     */
    public $parametrosCancelar; 
    
    /**
     * Encabezado para botones TIPO_AYUDA
     * @var strint 
     */
    public $encabezadoAyuda;
    
    /**
     * Texto para los botones TIPO_AYUDA
     * @var string 
     */
    public $textoAyuda;
    
    /**
     * Constructor del widget
     */
    public function init(){
        parent::init();
        $this->tipo = $this->tipo===NULL ? Boton::TIPO_ENVIAR_CANCELAR : $this->tipo;
        $this->etiquetaEnviar = $this->etiquetaEnviar===NULL ? 'Enviar' : $this->etiquetaEnviar;
        $this->parametrosCancelar = $this->parametrosCancelar===NULL ? ['index'] : $this->parametrosCancelar;
        $this->encabezadoAyuda = $this->encabezadoAyuda===NULL ? 'Ayuda' : $this->encabezadoAyuda;
        $this->textoAyuda = $this->textoAyuda===NULL ? '' : $this->textoAyuda;
    }
    
    /**
     * Función principal que realiza la ejecución del widget
     * @return type
     */
    public function run(){
        if($this->tipo == Boton::TIPO_ENVIAR_CANCELAR){
            return $this->enviarCancelar();    
        }
        
        if($this->tipo == Boton::TIPO_AYUDA){
            return $this->ayuda();    
        }
        
    } 
    
    /**
     * Crea un par de botones aceptar y cancelar
     * @return HTML botones de enviar y cancelar en HTML
     */
    private function enviarCancelar() {
        $botones = Html::submitButton($this->etiquetaEnviar, ['class' => 'btn btn-success']);
        $botones = !$this->etiquetaCancelar ? $botones :
                $botones . '&nbsp;' 
                . Html::a($this->etiquetaCancelar, $this->parametrosCancelar, ['class' => 'btn btn-danger']); 
        return $botones;

    }        

    /**
     * Función que despliega un PopoverX colocando el icono de ayuda como botón
     * @return HTML el widget de PopoverX
     */
    private function ayuda() {
        return PopoverX::widget([
            'header' => $this->encabezadoAyuda,
            'placement' => PopoverX::ALIGN_BOTTOM,
            'content' => $this->textoAyuda,
            'toggleButton' => ['tag' => 'span', 
                'label'=>'<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>'],
        ]);           
    }    
    
}

    
