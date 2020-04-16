<?php

namespace frontend\models;

use common\models\User;
use common\models\MyActiveRecord;
use Yii;

/**
 * This is the model class for table "departamentos".
 *
 * @property int $id
 * @property string $nombre Nombre del departamento
 * @property int $pais_id Relación con la tabla pais, pais al que pertenece el departamento
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property User $pais
 * @property Municipios[] $municipios
 * @property Proveedor[] $proveedors
 */

/**
 * This is the model class for table "departamentos".
 *
 * @property string $id
 * @property string $nombre Nombre del departamento
 * @property string $pais_id Relación con la tabla pais, pais al que pertenece el departamento
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 *
 * @property Combustibles[] $combustibles
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property User $pais
 * @property Municipios[] $municipios
 * @property OrdenesTrabajos[] $ordenesTrabajos
 * @property Proveedor[] $proveedors
 * @property Vehiculos[] $vehiculos
 */
class Departamentos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departamentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'pais_id'], 'required'],
            [['nombre', 'pais_id', 'creado_por', 'creado_el', 'actualizado_por', 'actualizado_el'], 'required'],
            [['pais_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['pais_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['pais_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'pais_id' => 'Pais ID',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCombustibles()
    {
        return $this->hasMany(Combustibles::className(), ['departamento_id' => 'id']);
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
    public function getPais()
    {
        return $this->hasOne(User::className(), ['id' => 'pais_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipios()
    {
        return $this->hasMany(Municipios::className(), ['departamento_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesTrabajos()
    {
        return $this->hasMany(OrdenesTrabajos::className(), ['departamento_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedors()
    {
        return $this->hasMany(Proveedor::className(), ['departamento_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculos()
    {
        return $this->hasMany(Vehiculos::className(), ['departamento_id' => 'id']);
    }
}
