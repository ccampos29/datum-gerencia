<?php

namespace backend\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * El model AuthItemChild se refiere a la combinación de permisos
 * 
 * Ejemplo:
 * 
 * r-super-admin tiene como hijo el r-admin
 *
 * @property string $parent identificador único rol/permiso padre
 * @property string $child identificador único rol/permiso hijo
 *
 * @property AuthItem $padre AuthItem padre
 * @property AuthItem $hijo AuthItem hijo
 */
class AuthItemChild extends ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'auth_item_child';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent'], 'sonIguales'],
            [['parent'], 'yaExisteRelacion'],
            [['parent'], 'creaCiclo'],
        ];
    }
    
    /**
     * ¿Son iguales?
     * 
     * Permite saber si la relación que se está creando tiene el mismo
     * permiso/rol como padre y como hijo; lo cuál, no es válido
     * 
     * @param type $attribute
     * @param type $params
     */
    public function sonIguales($attribute, $params) {
        if($this->child == $this->parent){
            $this->addError($attribute, "El padre y el hijo no pueden ser el mismo");
        } 
    }
    
    /**
     * ¿Ya existe relación?
     * 
     * Permite saber si la relación entre padre e hijo ya existe. Lo cúal,
     * no es válido
     * 
     * @param type $attribute
     * @param type $params
     */
    public function yaExisteRelacion($attribute, $params) {
        if(Yii::$app->authManager->hasChild($this->padre, $this->hijo)) {
            $this->addError($attribute, "La combinación de "
                    . "{$this->parent} - {$this->child} ya existe");
        }
    }
    
    /**
     * ¿Crea ciclo?
     * 
     * Permite saber si se crea un ciclo entre el hijo y el padre. Lo cuál
     * es inválido
     * 
     * @param type $attribute
     * @param type $params
     */
    public function creaCiclo($attribute, $params) {
        if(!Yii::$app->authManager->canAddChild($this->padre, $this->hijo)){
            $this->addError($attribute, "No puede adicionar $this->child"
                   . " como hijo de $this->parent, se crearía un ciclo");
        }
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'parent' => 'Rol/Permiso padre',
            'child' => 'Rol/Permiso hijo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPadre() {
        return $this->hasOne(AuthItem::className(), ['name' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHijo() {
        return $this->hasOne(AuthItem::className(), ['name' => 'child']);
    }
}
