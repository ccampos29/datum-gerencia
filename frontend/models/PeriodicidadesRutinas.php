<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "periodicidades_rutinas".
 *
 * @property int $id
 * @property int $vehiculo_id Es el automovil al que se le reporta la novedad
 * @property int $rutina_id Es la rutina asignada a la periodicidad
 * @property string $unidad_periodicidad Es la unidad de la periodicidad
 * @property string $trabajo_normal Es la cantidad de unidades de trabajo normal
 * @property string $trabajo_bajo Es la cantidad de unidades de trabajo bajo
 * @property string $trabajo_severo Es la cantidad de unidades de trabajo severo
 * @property int $tipo_periodicidad_id Es eel tipo de periodicidad
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Rutinas $rutina
 * @property TiposPeriodicidades $tipoPeriodicidad
 * @property Vehiculos $vehiculo
 */
class PeriodicidadesRutinas extends MyActiveRecord
{

    public $tipos;

    /**
     * Registra y/o Modifica la empresa en el modelo, según la empresa del usuario logueado
     * @param string $insert Query de inserción
     * @return mixed[]
     */
    public function beforeSave($insert) {
        $this->empresa_id = Yii::$app->user->identity->empresa_id;
        return parent::beforeSave($insert);
    }
    /**
     * Sobreescritura del método find para que siempre filtre por la empresa del usuario logueado
     * @return array Arreglo filtrado por empresa
     */
    public static function find()
    {
        return parent::find()->andFilterWhere(['empresa_id' =>@Yii::$app->user->identity->empresa_id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'periodicidades_rutinas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_periodicidad'], 'required'],
            [['vehiculo_id', 'tipo_periodicidad', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['unidad_periodicidad', 'trabajo_normal', 'trabajo_bajo', 'trabajo_severo'], 'string', 'max' => 255],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['rutina_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rutinas::className(), 'targetAttribute' => ['rutina_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehiculo_id' => 'Vehiculo',
            'rutina_id' => 'Rutina',
            'unidad_periodicidad' => 'Unidad Periodicidad',
            'trabajo_normal' => 'Trabajo Normal',
            'trabajo_bajo' => 'Trabajo Bajo',
            'trabajo_severo' => 'Trabajo Severo',
            'tipo_periodicidad' => 'Tipo Periodicidad',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
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
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculos::className(), ['id' => 'vehiculo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutina()
    {
        return $this->hasOne(Rutinas::className(), ['id' => 'rutina_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['id' => 'empresa_id']);
    }
}
