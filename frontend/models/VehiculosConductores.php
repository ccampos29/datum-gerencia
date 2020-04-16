<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use common\models\User;
use Yii;

/**
 * This is the model class for table "vehiculos_conductores".
 *
 * @property int $id
 * @property int $vehiculo_id Relacion con vehiculos
 * @property int $conductor_id Relacion con usuarios
 * @property string $fecha_desde Fecha desde la que el conductor es elegido
 * @property string|null $fecha_hasta Fecha en la que se cambia el conductor
 * @property int $dias_alerta Dias para que se genere la alerta correspondiente
 * @property int $principal Campo que refleja si el conductor es principal
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property User $conductor
 * @property Vehiculos $vehiculo
 */
class VehiculosConductores extends MyActiveRecord
{
    public $fecha_1, $fecha_2, $centro_costo_id;
    public $fecha2_1,$fecha2_2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehiculos_conductores';
    }
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
    public function rules()
    {
        return [
            [['vehiculo_id', 'conductor_id', 'fecha_desde', 'dias_alerta', 'principal', 'estado'], 'required'],
            [['vehiculo_id', 'conductor_id', 'dias_alerta', 'principal', 'creado_por', 'actualizado_por', 'empresa_id', 'estado'], 'integer'],
            [['fecha_desde', 'fecha_hasta', 'creado_el', 'actualizado_el'], 'safe'],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['conductor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['conductor_id' => 'id']],
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
            'vehiculo_id' => 'Vehiculo',
            'conductor_id' => 'Conductor',
            'fecha_desde' => 'Fecha Desde',
            'fecha_hasta' => 'Fecha Hasta',
            'dias_alerta' => 'Dias Alerta',
            'principal' => 'Principal',
            'creado_por' => 'Creado Por',
            'estado' => 'Estado',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
        ];
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
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['id' => 'empresa_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConductor()
    {
        return $this->hasOne(User::className(), ['id' => 'conductor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculos::className(), ['id' => 'vehiculo_id']);
    }
}