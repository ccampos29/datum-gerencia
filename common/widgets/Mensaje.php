<?php

namespace common\widgets;

use \yii\bootstrap\Widget;

/**
 * Widget que permite añadir diferentes tipos de mensajes en las vistas
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class Mensaje extends Widget{
    const TIPO_PREDETERMINADO = 'predeterminado';
    const TIPO_EXITO = 'exito';
    const TIPO_INFORMACION = 'informacion';
    const TIPO_ADVERTENCIA = 'advertencia';
    const TIPO_ERROR = 'error';
    const TIPO_AYUDA = 'ayuda';
    const TIPO_LISTA = 'lista';
    
    /**
     * Tipo de mensaje a utilizar  
     * @var string 
     */
    public $tipo; 
    
    /**
     * Título que tendrá el mensaje. Si el mensaje es TIPO_LISTA, este atributo
     * es obligatorio
     * @var string 
     */
    public $titulo; 
    
    /**
     * Indica si el mensaje estará acompañado de un ícono
     * @var boolean
     */
    public $mostrarIcono;
    
    /**
     * Indica si el mensaje estará acompañado por un separador entre el
     * título y el contenido
     * @var type 
     */
    public $mostrarSeparador;
    
    /**
     * Texto principal del mensaje
     * @var string 
     */
    public $contenido;
    
    /**
     * Arreglo de los items (string) que tendrá la lista 
     * @var array 
     */
    public $contenidoLista;

    /**
     * Constructor del widget
     */
    public function init(){
        parent::init();
        $this->tipo = $this->tipo===NULL ? Mensaje::TIPO_PREDETERMINADO : $this->tipo;
        $this->mostrarIcono = $this->mostrarIcono===NULL ? FALSE : $this->mostrarIcono;
        $this->mostrarSeparador = $this->mostrarSeparador===NULL ? FALSE : $this->mostrarSeparador;
        $this->contenido = $this->contenido===NULL ? '' : $this->contenido;
        $this->contenidoLista = $this->contenidoLista===NULL ? [] : $this->contenidoLista;
    }
     
    /**
     * Función principal que realiza la ejecución del widget
     * @return HTML el mensaje configurado en HTML
     */
    public function run(){
        $mensaje = "";
                
        if($this->tipo == Mensaje::TIPO_PREDETERMINADO){
            $mensaje = $this->plantilla();
        } elseif ($this->tipo == Mensaje::TIPO_EXITO) {
            $mensaje = $this->plantilla('alert-success', 'glyphicon-ok-sign');
        } elseif ($this->tipo == Mensaje::TIPO_INFORMACION) {
            $mensaje = $this->plantilla('alert-info', 'glyphicon-info-sign');
        } elseif ($this->tipo == Mensaje::TIPO_ADVERTENCIA) {
            $mensaje = $this->plantilla('alert-warning', 'glyphicon-exclamation-sign');        
        } elseif ($this->tipo == Mensaje::TIPO_ERROR) {
            $mensaje = $this->plantilla('alert-danger', 'glyphicon-remove-sign');
        } elseif ($this->tipo == Mensaje::TIPO_AYUDA) {
            $mensaje = $this->plantilla('alert-info', 'glyphicon-question-sign');
        } elseif ($this->tipo == Mensaje::TIPO_LISTA) {
            $mensaje = $this->lista();
        }
        return $mensaje;
    } 
    
    /**
     * Crea el mensaje según la configuración del widget
     * 
     * @return string plantilla
     */
    private function plantilla($clase = 'alert-info' ,$icono = '') {
        $mensaje = '<div class="alert kv-alert ' . $clase . '  ">';
        
        $mensaje = !$this->mostrarIcono ? $mensaje :
                $mensaje . '<span class="glyphicon ' . $icono . ' kv-alert-title"></span> ';
        
        $mensaje = !$this->titulo ? $mensaje :
                $mensaje . '<span class="kv-alert-title" ">' . '<strong>' . $this->titulo . '</strong>' . '<br></span>';
        
        $mensaje = !$this->mostrarSeparador ? $mensaje :
                $mensaje . '<hr class="kv-alert-separator">';
        
        $mensaje = $mensaje . $this->contenido . '</div>';
                
        return $mensaje;
    }
    
    /**
     * Crea un mensaje con el arreglo de items (string) del widget
     * @return string
     */
    private function lista() {
        $mensaje = "<blockquote> <p> $this->titulo </p>";
        
        foreach ($this->contenidoLista as $item) {
            $mensaje = $mensaje . "<small> $item </small>";
        }
        
        $mensaje = $mensaje .  "</blockquote>";

        return $mensaje;
    }
  
}

    
