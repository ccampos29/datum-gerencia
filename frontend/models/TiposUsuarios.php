<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;
use common\models\User;
/**
 * This is the model class for table "tipos_usuarios".
 *
 * @property int $id
 * @property string $descripcion Descripción del tipo de usuario
 * @property string $permiso_rol Permiso o rol con el que esta asociado este tipo de usuario
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property User[] $users
 * @property UsuariosTiposUsuarios[] $usuariosTiposUsuarios
 */
class TiposUsuarios extends MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipos_usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'permiso_rol'], 'required'],
            [['creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el','permiso_rol'], 'safe'],
            [['descripcion', 'permiso_rol'], 'string', 'max' => 255],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'permiso_rol' => 'Permiso Rol',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActualizadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['tipo_usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuariosTiposUsuarios()
    {
        return $this->hasMany(UsuariosTiposUsuarios::className(), ['tipo_usuario_id' => 'id']);
    }
}
