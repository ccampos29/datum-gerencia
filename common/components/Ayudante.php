<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\db\Expression;
use yii\helpers\Html;
use yii\db\Query;

/**
 * La clase Ayudante agrupa varias funciones de uso común
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class Ayudante extends Component {

    /**
     * Retorna un array para lista desplegable con los valores de un campo tipo enum
     * 
     * @param string $tabla nombre de la tabla en base de datos
     * @param string $campo nombre del campo de la tabla en base de datos
     * @return array $arrayRes lista con las opciones del enum  
     */
    public static function datosEnum($tabla, $campo) {
        // Obtener información del campo tipo enum, retorna un array
        $sql = "SHOW COLUMNS FROM $tabla LIKE '$campo';";
        $command = Yii::$app->db->createCommand($sql);
        $tmp = $command->queryOne();

        // Tomar del array el array que tiene el enum
        // Retorna algo como lo siguiente:
        // enum('Público General','Empresa')
        $tmp = $tmp['Type'];

        // Se quita los caracteres de inicio y final para que solo quede
        // una array lista. Quedaría algo como;
        // 'Público General','Empresa'
        $tmp = str_replace('enum(', '', $tmp);
        $tmp = substr($tmp, 1, -2);

        // Ahora se hace un array con los elementos quitando las comillas
        // y colocando los mismos datos como clave y valor
        $arrayTmp = explode("','", $tmp);
        $arrayRes = [];

        foreach ($arrayTmp as $key => $value) {
            $arrayRes[$value] = $value;
        }

        return $arrayRes;
    }

    /**
     * Retorna el siguiente array [1 => 'Si', 0 => 'No']
     * 
     * @return array el arreglo mencionado anteriormente
     */
    public static function booleanArray() {
        return [1 => 'Si', 0 => 'No'];
    }

    /**
     * Permite cambiar el tamaño de los botones de las columnas de acciones
     * de los GridView
     * 
     * @param array $arregloBotones lista de nombre de los botones a incluir en el formato
     * @return string el nuevo formato
     */
    public static function cambiarEstiloPlantilla($arregloBotones) {
        $botones = "";
        foreach ($arregloBotones as $boton) {
            $botones = $botones . "{" . $boton . "} ";
        }
        $plantillaConFormato = '<h4>' .
                $botones .
                '</h4>';
        return $plantillaConFormato;
    }

    /**
     * Guarda la URL de retorno a la dirección actual
     */
    public static function guardarUrlRetorno() {
        Yii::$app->user->returnUrl = Yii::$app->request->url;
    }

    /**
     * Retorna los errores del modelo en una lista HTML no ordenada
     *
     * @return string la lista con formato HTML
     */
    public static function obtenerStringErrores($model) {
        $errores_tmp = $model->getErrors();
        $resultado = "<ul>";

        foreach ($errores_tmp as $errorAtributo) {
            foreach ($errorAtributo as $error) {
                $resultado .= "<li>" . $error . "</li>";
            }
        }
        $resultado .= "</ul>";

        return $resultado;
    }

    /**
     * Realiza comparación de elementos entre dos arreglos (A-B), 
     * retornando un nuevo arreglo con el resultado de la diferencia; es decir,
     * los elementos de A que no están en B.
     * 
     * @param array $elementosA lista de elementosA comparación inicial.
     * @param array $elementosB lista de elementosB comparación final.
     * @return array los elementos de A que no están en B.
     */
    public static function elementosAQueNoEstanEnB($elementosA, $elementosB) {
        $noEstan = [];

        $elementosA = is_array($elementosA) ? $elementosA : [];
        $elementosB = is_array($elementosB) ? $elementosB : [];

        foreach ($elementosA as $elementoA) {
            if (!in_array($elementoA, $elementosB)) {
                array_push($noEstan, $elementoA);
            }
        }

        return $noEstan;
    }

    /**
     * Retorna la información:
     * Creado por, Creado el, Actualizado por y Actualizado el
     * 
     * @return $datosAuditoria array con la información
     */
    public static function datosAuditoria() {
        $datosAuditoria = [
            'creado_por' => Yii::$app->user->id,
            'creado_el' => new Expression('NOW()'),
            'actualizado_por' => Yii::$app->user->id,
            'actualizado_el' => new Expression('NOW()'),
        ];

        return $datosAuditoria;
    }
    
    /**
     * Método que muestra los mensajes de errores
     * @author Michael Rosero
     * @param Object Modelo a comparar
     */
    public static function getErroresSave($model){
        if(!empty($model->errors)){
            foreach($model->errors as $error){
                Yii::$app->session->setFlash('danger', $error);
            }
        }
    }

     /**
     * Método para llenar un select-ajax
     * @param string $q Valor a buscar
     * @param array query resultado 
     * @return array Resultados encontrados según la búsqueda 
     */
    public static function getSelectAjax($q = null, $id = null, $select, $table, $columna = 'nombre') {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $query = new Query;
        $query->select($select)
                ->from($table)
                ->andFilterWhere(['like', $columna, $q])
                ->andFilterWhere(['empresa_id'=>@Yii::$app->user->identity->empresa_id])
                ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);
        return $out;
    }
    
}
