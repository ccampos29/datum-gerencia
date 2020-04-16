<?php

namespace common\widgets;

use \yii\bootstrap\Widget;
use kartik\helpers\Html;

/**
 * Widget que permite añadir diferentes tipos de títulos en las vistas.
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class Titulo extends Widget{
    const TIPO_PRINCIPAL = 'principal';
    const TIPO_SUBTITULO = 'subtitulo';
    const TIPO_SECCION = 'seccion';

    /**
     * Tipo de título
     * @var string 
     */
    public $tipo;
    
    /**
     * Texto que tendrá cuando es TIPO_PRINCIPAL
     * @var string 
     */
    public $titulo;
    
    /**
     * Información que complementa un título TIPO_PRINCIPAL 
     * @var string 
     */
    public $informacionAdicionalTitulo;
    
    /**
     * Texto que tendrá cuando es TIPO_SUBTITULO
     * @var string 
     */
    public $subtitulo;
    
    /**
     * Información que complementa un subtítulo TIPO_SUBTITULO 
     * @var string 
     */
    public $informacionAdicionalSubtitulo;
    
    /**
     * Texto que tendrá cuando es TIPO_SECCION
     * @var string 
     */
    public $nombreSeccion;

    /**
     * Constructor del widget
     */
    public function init(){
        parent::init();
        $this->tipo = $this->tipo===null ? Titulo::TIPO_PRINCIPAL : $this->tipo;
        
        $this->titulo = $this->titulo===null ? '' : $this->titulo;
        $this->informacionAdicionalTitulo = $this->informacionAdicionalTitulo===null 
                    ? '' : $this->informacionAdicionalTitulo;
        
        $this->subtitulo = $this->subtitulo===null ?  '' : $this->subtitulo;
        $this->informacionAdicionalSubtitulo = $this->informacionAdicionalSubtitulo===null 
                    ?  '' : $this->informacionAdicionalSubtitulo;
        
        $this->nombreSeccion = $this->nombreSeccion===null ?  '' : $this->nombreSeccion;
    }
     
    /**
     * Función principal que realiza la ejecución del widget
     * @return retorna un título
     */
    public function run(){
        if($this->tipo == Titulo::TIPO_PRINCIPAL){
            return $this->principal();    
        }
        
        if($this->tipo == Titulo::TIPO_SUBTITULO){
            return $this->subtitulo();    
        }
        
        if($this->tipo == Titulo::TIPO_SECCION){
            return $this->seccion();    
        }
        
    }
    
    /**
     * Crea un título principal
     * @return HTML título en HTML
     */
    private function principal(){
        $tituloConFormato = Html::pageHeader(
                $this->titulo, $this->informacionAdicionalTitulo);
        return $tituloConFormato;
    }
    
    /**
     * Crea un subtítulo 
     * @return HTML subtítulo en HTML
     */
    private function subtitulo(){
        $subtituloConFormato = "<h2><small>$this->subtitulo <small> "
                . "$this->informacionAdicionalSubtitulo</small></small></h2>";
        
        return $subtituloConFormato;
    }
    
    /**
     * Crea un título de sección
     * @return HTML título de sección en HTML
     */
    private function seccion(){
        return "<legend class='text-info'><small>$this->nombreSeccion</small></legend>";
    }

}
