<?php

namespace common\widgets;

use \yii\bootstrap\Widget;
use common\models\Circulo;

/**
 * Widget que permite añadir un menú de pasos para un modelo
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class Paso extends Widget {

    /**
     * Arreglo con los pasos a graficar
     * @var array 
     */
    public $arrayPasos;
    
    /**
     * Identificador único del modelo
     * @var type 
     */
    public $modelId;
    
    /**
     * Indica el paso que debe aparecer como activo
     * @var Paso 
     */
    public $paso;

    /**
     * Constructor del widget
     */
    public function init() {
        parent::init();
        $this->arrayPasos = $this->arrayPasos === null ? [] : $this->arrayPasos;
        $this->modelId = $this->modelId === null ? -1 : $this->modelId;
        $this->paso = $this->paso === null ? 0 : $this->paso;
    }

    /**
     * Función principal que realiza la ejecución del widget
     * @return retorna los pasos agrupados en HTML
     */
    public function run() {
        if (!empty($this->arrayPasos)) {

            for ($i = 0; $i < count($this->arrayPasos); $i++) {
                $this->arrayPasos[$i]->tipo = Circulo::TIPO_COMPLETO;
            }

            if ($this->modelId == -1) {
                for ($i = 0; $i < count($this->arrayPasos); $i++) {
                    $this->arrayPasos[$i]->tipo = Circulo::TIPO_INACTIVO;
                    $this->arrayPasos[$i]->enlace = '#';
                }
                $this->arrayPasos[$this->paso]->tipo = Circulo::TIPO_ACTIVO_DIFERENTE;
            } else {
                for ($i = 0; $i < count($this->arrayPasos); $i++) {
                    $this->arrayPasos[$i]->tipo = Circulo::TIPO_COMPLETO;
                }
                $this->arrayPasos[$this->paso]->tipo = Circulo::TIPO_ACTIVO;
            }
            
            return Circulo::proceso($this->arrayPasos);
        }
    }

}
