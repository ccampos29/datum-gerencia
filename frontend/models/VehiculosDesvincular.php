<?php

namespace frontend\models;
use common\models\User;
use common\models\MyActiveRecord;
use Yii;

/**
 * This is the model class for table "vehiculos_desvincular".
 *
 * @property int $id
 * @property string $fecha_desvinculacion Fecha de desvinculacion de un vehiculo a la plataforma
 * @property string $observacion Motivo de la desvinculacion
 * @property int $vehiculo_id Dato intermedio entre vehiculos_vincular y vehiculos
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property Vehiculos[] $vehiculos
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Vehiculos $vehiculo
 */
class VehiculosDesvincular extends MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehiculos_desvincular';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fecha_desvinculacion', 'vehiculo_id', 'creado_por', 'creado_el', 'actualizado_por', 'actualizado_el'], 'required'],
            [['id', 'vehiculo_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['fecha_desvinculacion', 'creado_el', 'actualizado_el'], 'safe'],
            [['observacion'], 'string'],
            [['id'], 'unique'],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_desvinculacion' => 'Fecha Desvinculacion',
            'observacion' => 'Observacion',
            'vehiculo_id' => 'Vehiculo ID',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculos()
    {
        return $this->hasMany(Vehiculos::className(), ['vehiculo_desvincular_id' => 'id']);
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
    public function getCreadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculos::className(), ['id' => 'vehiculo_id']);
    }
}
