<?php

namespace frontend\models;
use common\models\User;
use Yii;

/**
 * This is the model class for table "vehiculos_equipos".
 *
 * @property int $id
 * @property int $vehiculo_id Relacion con vehiculos
 * @property int $vehiculo_vinculado_id Relacion con vehiculos
 * @property string $fecha_desde Fecha desde la que se vinculan los equipos
 * @property string|null $fecha_hasta Fecha en la que se desvinculan los equipos
 * @property int $estado Campo que refleja si el estado es activo o no
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property Vehiculos $vehiculo
 * @property Vehiculos $vehiculoVinculado
 */
class VehiculosEquipos extends \common\models\MyActiveRecord
{
    public $medicion;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehiculos_equipos';
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
            [['vehiculo_id', 'vehiculo_vinculado_id', 'fecha_desde', 'estado'], 'required'],
            [['vehiculo_id', 'vehiculo_vinculado_id', 'estado', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['fecha_desde', 'fecha_hasta', 'creado_el', 'actualizado_el'], 'safe'],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['vehiculo_vinculado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_vinculado_id' => 'id']],
            [['fecha_desde', 'fecha_hasta'], 'validarFechas']
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
            'vehiculo_vinculado_id' => 'Vehiculo vinculado',
            'fecha_desde' => 'Fecha Desde',
            'fecha_hasta' => 'Fecha Hasta',
            'estado' => 'Estado',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
            'medicion' => 'Sumatoria de mediciones'
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
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculos::className(), ['id' => 'vehiculo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculoVinculado()
    {
        return $this->hasOne(Vehiculos::className(), ['id' => 'vehiculo_vinculado_id']);
    }

    public function validarFechas()
    {
        $fechaDesde = strtotime($this->fecha_desde);
        $fechaHasta = strtotime($this->fecha_hasta);
        
        $error = null;
        if (!empty($fechaDesde) && !empty($fechaHasta)) {
            if ($fechaHasta < $fechaDesde) {
                $error = 'La fecha final de vinculacion no puede ser menor que la fecha inicual de vinculacion.';
                $this->addError('fecha_hasta', $error);
            }
            if ($fechaHasta == $fechaDesde) {
                $error = 'La fecha final de vinculacion no puede ser igual a la fecha inicial de vinculacion.';
                $this->addError('fecha_hasta', $error);
            }
        }
        
    
    }
}
