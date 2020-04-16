<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "tipos_checklist_detalle".
 *
 * @property int $id
 * @property int $tipo_checklist_id
 * @property int $tipo_vehiculo_id Relación con el tipo de vehiculos a los cuales se les puede hacer este checklist
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property TiposChecklist $tipoChecklist
 * @property TiposVehiculos $tipoVehiculo
 */
class TiposChecklistDetalle extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipos_checklist_detalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_checklist_id', 'tipo_vehiculo_id'], 'required'],
            [['tipo_checklist_id', 'tipo_vehiculo_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['tipo_checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposChecklist::className(), 'targetAttribute' => ['tipo_checklist_id' => 'id']],
            [['tipo_vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposVehiculos::className(), 'targetAttribute' => ['tipo_vehiculo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_checklist_id' => 'Tipo Checklist ID',
            'tipo_vehiculo_id' => 'Tipo Vehiculo ID',
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
    public function getTipoChecklist()
    {
        return $this->hasOne(TiposChecklist::className(), ['id' => 'tipo_checklist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoVehiculo()
    {
        return $this->hasOne(TiposVehiculos::className(), ['id' => 'tipo_vehiculo_id']);
    }
}
