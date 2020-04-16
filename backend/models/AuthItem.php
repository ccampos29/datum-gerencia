<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use common\models\AuthMenuItem;

/**
 * El modelo AuthItem se refiere a los roles y permisos existentes en el sistema
 * 
 * Ejemplo:
 * r-admin es un AuthItem y representa el rol de administrador
 * 
 * @property string $name nombre
 * @property int $type tipo
 * @property string $description descripción
 * @property string $rule_name nombre regla asociada
 * @property string $data data
 * @property datetime $created_at creado el
 * @property datetime $updated_at actualizado el
 *
 * @property AuthAssignment[] $authAssignments lista objetos de tipo AuthAssignment
 * @property User[] $users lista de usuarios
 * @property AuthRule $ruleName la regla asociada
 * @property AuthItemChild[] $authItemChildren AuthItemChild hijos
 * @property AuthItemChild[] $authItemParents AuthItemChild padres
 * @property AuthMenuItem[] $authMenuItems AuthMenuItem asociados
 * 
 * @property string $tipoTexto nombre del tipo
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class AuthItem extends ActiveRecord {
    const TIPO_ROL = 1;
    const TIPO_ROL_TEXTO = 'Rol';
    const TIPO_PERMISO = 2;
    const TIPO_PERMISO_TEXTO = 'Permiso';
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'auth_item';
    }  
    
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];        
    }    

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'type'], 'required'],
            [['name'], 'unique'],
            [['type', ], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => 'Rol/Permiso',
            'type' => 'Tipo',
            'description' => 'Descripción',
            'rule_name' => 'Nombre regla asociada',
            'data' => 'Data',
            'created_at' => 'Creado el',
            'updated_at' => 'Actualizado el',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments() {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('auth_assignment', ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName() {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren() {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemParents() {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthMenuItems() {
        return $this->hasMany(AuthMenuItem::className(), ['auth_item' => 'name']);
    }

    /**
     * @return string el tipo
     */
    public  function getTipoTexto() {
        $tipo = ($this->type == AuthItem::TIPO_ROL) 
                ? AuthItem::TIPO_ROL_TEXTO : AuthItem::TIPO_PERMISO_TEXTO; 
        return $tipo;
    } 
    
    /**
     * Crea un arreglo con la lista de todos los roles del sistema a excepción
     * del rol: r-super-admin el cuál, se debe agregar únicamente por base de datos
     * 
     * @return array lista de roles [id => descripcion]
     */
    public static function rolesNombreDescripcion() {
        $roles = Yii::$app->authManager->getRoles();
        $rolesArray = ArrayHelper::map($roles, 'name', 'description');
        ArrayHelper::remove($rolesArray, 'r-super-admin');
        
        return $rolesArray;
    } 

    
    /**
     * Crea un arreglo con el label según el tipo
     * 
     * @return array lista de label [id_tipo => label]
     */
    public static function arrayTipo() {
        return [
            self::TIPO_ROL => self::TIPO_ROL_TEXTO,
            self::TIPO_PERMISO => self::TIPO_PERMISO_TEXTO,
        ];
    } 
    
    /**
     * Lista los roles/permisos y subroles/subpermisos
     * 
     * @return array nodos con el análisis de roles/permisos
     */
    public static function arbolPermisos(){
        $todos = self::find()->orderBy(['type' => SORT_ASC, 'name' => SORT_ASC, ])->all();
        
        $nodos = [];
        foreach ($todos as $key => $permiso) {
            $nodos[] = self::analisisPermisos($permiso->name, "");
        }
        return $nodos;
    }

    /**
     * Recursión que permite obtener el árbol completo (padres e hijos) de los
     * roles/permisos
     * 
     * @param string $padre padre inicial
     * @param string $texto label de como se va a ver en el árbol
     * @return array si es hoja retorna un arreglo con el texto; si es una rama
     * retorna un arreglo con el texto y sus nodos hijos
     */
    public static function analisisPermisos($padre, $texto){
        $modeloPadre = self::find()->where('name = :name', [':name' => $padre])->one();
        $hijos = AuthItemChild::find()->where('parent = :padre', 
                [':padre' => $padre])->orderBy(['parent' => SORT_ASC, 'child' => SORT_ASC, ])->all();
        
        if($hijos){
            
            $nodos = [];
            foreach ($hijos as $key => $hijo) {
                $nodos[] = self::analisisPermisos($hijo->child, $texto);
            }
            
            return [ //rama 
                    'text' => "($modeloPadre->type) - [$modeloPadre->name]" , 
                    'nodes' => $nodos,
                ];           
                
        } else {
            return //hoja;
                [ 
                    'text' => "($modeloPadre->type) - [$modeloPadre->name]" , 
                ];
        }
    }        
    
    /**
     * Permite saber si un AuthItem se puede eliminar
     * 
     * @return boolean TRUE si se puede eliminar, FALSE de lo contrario
     */
    public function sePuedeEliminar() {
        if($this->authAssignments){
            return FALSE;
        }
        
        if($this->authItemChildren){
            return FALSE;
        }
        
        if($this->authItemParents){
            return FALSE;
        }
        
        if($this->authMenuItems){
            return FALSE;
        }
        
        return TRUE;    
    }
    
    /**
     * Objetos que están relacionados a través de otros objetos, modelos o tablas
     * que restringen el delete
     * 
     * @return string detalle de los objetos con los cuales está relacionado
     */
    public function objetosRelacionados() {
        $detalle = '';
        
        if($this->authAssignments){    
            $detalle .= 'Permisos vs. Usuarios: <ul>';
            foreach ($this->authAssignments as $authAssignment) {
                $detalle .= '<li>'.$authAssignment->user->nombresYApellidos.'</li>';
            }
            $detalle .= '</ul>';
        }
        
        if($this->authItemChildren){    
            $detalle .= 'Es padre de los roles/permisos: <ul>';
            foreach ($this->authItemChildren as $authItemChildren) {
                $detalle .= '<li>'.$authItemChildren->child.'</li>';
            }
            $detalle .= '</ul>';
        }
        
        if($this->authItemParents){    
            $detalle .= 'Es hijo de los roles/permisos: <ul>';
            foreach ($this->authItemParents as $authItemParent) {
                $detalle .= '<li>'.$authItemParent->parent.'</li>';
            }
            $detalle .= '</ul>';
        }
        
        if($this->authMenuItems){    
            $detalle .= 'Es requerido en los menús: <ul>';
            foreach ($this->authMenuItems as $authMenuItem) {
                $detalle .= '<li>'.$authMenuItem->name.'</li>';
            }
            $detalle .= '</ul>';
        }
        
        return $detalle;
    }
}
