<?php

namespace backend\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use common\models\User;

/**
 * El modelo AuthAssignment se refiere a la asignación de roles/permisos a 
 * un usuario
 *
 * @property string $item_name rol/permiso
 * @property int $user_id identificador único del usuario
 * @property datetime $created_at creado el
 *
 * @property AuthItem $authItem rol/permiso
 * @property User $user usuario
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class AuthAssignment extends ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'auth_assignment';
    }
    
    /**
     * Leer documentación de Yii2
     * 
     * @link http://www.yiiframework.com/doc-2.0/guide-concept-behaviors.html
     * @return array
     */
    public function behaviors() {
        $arrayBehaviors = [];

        $arrayBehaviors['timestamp'] = [
            'class' => TimestampBehavior::className(),
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
            ],
            'value' => new Expression('NOW()'),
        ];          
            
        return $arrayBehaviors;
    }  

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['item_name', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],

            [['item_name'], 'string', 'max' => 64],
            [['item_name'], 'unique', 
                'targetAttribute' => ['item_name', 'user_id'], 
                'message' => 'El rol/permiso ya esta asignado al usuario seleccionado'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'item_name' => 'Rol/Permiso',
            'user_id' => 'Usuario',
            'created_at' => 'Creado el',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItem() {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }       

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
