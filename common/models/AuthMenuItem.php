<?php

namespace common\models;

use Yii;

/**
 * El modelo AuthMenuItem representa un item de menú o submenú
 * 
 * Ejemplo:
 * 
 * "Sistema" es un menú y "Parametrización básica" es un submenú
 *
 * @property int $id identificador único
 * @property int $padre padre
 * @property int $orden orden en que aparecerán las opciones
 * @property string $auth_item nombre del rol/permiso
 * @property string $name nombre del menú
 * @property string $label etiqueta
 * @property string $ruta ruta a donde lleva el menú
 * @property string $icono icono que se ve al lado del menú
 * @property int $separador ¿Incluye separador después del item?
 * @property string $tipo ¿A cuál aplicación pertenece?
 * @property string $visible si es visible para el usuario
 * @property string $descripcion descripción
 * @property int $creado_por creado por
 * @property datetime $creado_el creado el
 * @property int $actualizado_por actualizado por
 * @property datetime $actualizado_el actualizado el
 *
 * @property AuthItem $authItem permiso
 * @property AuthMenuItem $menuPadre menú padre
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class AuthMenuItem extends MyActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'auth_menu_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['padre', 'orden', 'visible', 'separador'], 'integer'],
            [['auth_item', 'name', 'label', 'tipo', 'ruta', 'visible'], 'required'],
            [['tipo', 'descripcion'], 'string'],
            [['auth_item'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 40],
            [['label'], 'string', 'max' => 60],
            [['ruta', 'icono'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['padre'], 'sonIguales'],
            [['tipo', 'descripcion', 'auth_item', 'name', 'label', 'ruta', 'icono'], 'filter', 'filter' => 'trim'],
        ];
    }
    
    /**
     * ¿Son iguales?
     * 
     * Permite saber si la relación que se está creando tiene el mismo
     * menú como padre y como hijo; lo cuál, no es válido
     * 
     * @param type $attribute
     * @param type $params
     */
    public function sonIguales($attribute, $params) {
        if($this->id == $this->padre){
            $this->addError($attribute, "El padre y el hijo no pueden ser el mismo");
        } 
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'padre' => 'Padre',
            'orden' => 'Orden',
            'auth_item' => 'Permiso',
            'name' => 'Nombre',
            'label' => 'Etiqueta',
            'ruta' => 'Ruta',
            'icono' => 'Icono',
            'separador' => '¿Separador?',
            'tipo' => 'Tipo',
            'visible' => 'Visible',
            'descripcion' => 'Descripción',
            'creado_por' => 'Creado por',
            'creado_el' => 'Creado el',
            'actualizado_por' => 'Actualizado por',
            'actualizado_el' => 'Actualizado el',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItem() {
        return $this->hasOne(\backend\models\AuthItem::className(), ['name' => 'auth_item']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuPadre() {
        return $this->hasOne(AuthMenuItem::className(), ['id' => 'padre']);
    }

    /**
     * Crea el menú de forma dinámica utilizando la información
     * de la base de datos
     * 
     * @param string $padre rama desde la cual se comienza a armar el menú
     * @param string $tipo puede ser 'administracion' o 'aplicacion'
     * @return array arreglo con todas las opciones del menú
     */
    public static function crearMenu($padre, $tipo){
        $menuPadre = AuthMenuItem::find()->where('id = :id', [':id' => $padre])->one();
        $hijos = self::find()
                ->where('padre = :padre', [':padre' => $padre])
                ->andWhere('tipo = :tipo', [':tipo' => $tipo])
                ->orderBy('orden')
                ->all();        
        
        if($hijos){
            $items = [];
            foreach ($hijos as $key => $hijo) {
                $items[] = self::crearMenu($hijo->id, $tipo);
                if($hijo->separador) {
                    $items[] = '<li class="divider"></li>';
                }
            }
            
            return [ //rama
                    'label' => "<span class='$menuPadre->icono' aria-hidden='true'></span> $menuPadre->label",
                    'url' => [$menuPadre->ruta],
                    'visible' => Yii::$app->user->can($menuPadre->auth_item)
                            && $menuPadre->visible,
                    'items' => $items,
                ];           
                
        } else {
            return //hoja;
                [ 
                    'label' => "<span class='$menuPadre->icono' aria-hidden='true'></span> $menuPadre->label",
                    'url' => [$menuPadre->ruta],
                    'visible' => Yii::$app->user->can($menuPadre->auth_item)
                            && $menuPadre->visible,
                ];
        }
    }
    
    /**
     * Crea una lista jerárquica con las opciones del menú sin considerar
     * los permisos
     * 
     * @param string $padre rama desde la cual se comienza a armar el menú
     * @param string $tipo puede ser 'administracion' o 'aplicacion'
     * @return array arreglo con todas las opciones del menú
     */
    public static function analisisMenu($padre, $tipo){
        
        $padreObj = AuthMenuItem::find()->where('id = :id', [':id' => $padre])->one();
        $hijos = self::find()
                    ->where('padre = :padre', [':padre' => $padre])
                    ->andWhere('tipo = :tipo', [':tipo' => $tipo])
                    ->orderBy('orden')
                    ->all();
        
        if($hijos){
            
            $nodes = [];
            foreach ($hijos as $key => $hijo) {
                $nodes[] = self::analisisMenu($hijo->id, $tipo);
            }
            
            return [ //rama 
                    'text' => "[$padreObj->name - "
                    . "<span class='$padreObj->icono' aria-hidden='true'></span>"
                    . "$padreObj->label] - [$padreObj->ruta] - [$padreObj->auth_item]" , 
                    'nodes' => $nodes,
                ];           
                
        } else {
            return //hoja;
                [ 
                    'text' => "[$padreObj->name - "
                    . "<span class='$padreObj->icono' aria-hidden='true'></span>"
                    . "$padreObj->label] - [$padreObj->ruta] - [$padreObj->auth_item]" , 
                ];
        }
    }    
}
