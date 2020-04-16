<?php

namespace backend\models;
use yii\db\ActiveRecord;


/**
 * El modelo AuthRule se refiere a reglas o restricciones especiales 
 * que se pueden agregar a los roles/permisos (AuthItem)
 *
 * @property string $name nombre
 * @property string $data data
 * @property datetime $created_at creado el
 * @property datetime $updated_at actualizado el
 *
 * @property AuthItem[] $authItems lista de permisos en los que se aplica esta
 * regla
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class AuthRule extends ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'auth_rule';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => 'Nombre',
            'data' => 'Data',
            'created_at' => 'Creado el',
            'updated_at' => 'Actualizado el',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItems()
    {
        return $this->hasMany(AuthItem::className(), ['rule_name' => 'name']);
    }
}
