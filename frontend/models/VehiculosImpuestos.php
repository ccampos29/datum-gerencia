<?php

namespace frontend\models;
use common\models\User;
use common\models\MyActiveRecord;
use Yii;

/**
 * This is the model class for table "vehiculos_impuestos".
 *
 * @property int $id
 * @property float $valor_impuesto Valor del impuesto
 * @property string $fecha_expedicion Fecha de expedicion del impuesto
 * @property string $fecha_expiracion Fecha de expiracion del impuesto
 * @property string|null $descripcion Descripción del tipo de impuesto
 * @property int $vehiculo_id Dato intermedio entre vehiculos_impuestos y vehiculos
 * @property int $centro_costo_id Dato intermedio entre vehiculos_impuestos y centros_costos
 * @property int $tipo_impuesto_id Dato intermedio entre vehiculos_impuestos y tipos_impuestos
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Vehiculos $vehiculo
 * @property CentrosCostos $centroCosto
 * @property TiposImpuestos $tipoImpuesto
 * @property Empresas $empresa
 */
class VehiculosImpuestos extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehiculos_impuestos';
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
        return parent::find()->andFilterWhere(['empresa_id'=>@Yii::$app->user->identity->empresa_id]);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['valor_impuesto', 'fecha_expedicion', 'fecha_expiracion', 'vehiculo_id', 'centro_costo_id', 'tipo_impuesto_id'], 'required'],
            [['valor_impuesto'], 'number'],
            [['fecha_expedicion', 'fecha_expiracion', 'creado_el', 'actualizado_el'], 'safe'],
            [['descripcion'], 'string'],
            [['vehiculo_id', 'centro_costo_id', 'tipo_impuesto_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['centro_costo_id'], 'exist', 'skipOnError' => true, 'targetClass' => CentrosCostos::className(), 'targetAttribute' => ['centro_costo_id' => 'id']],
            [['tipo_impuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposImpuestos::className(), 'targetAttribute' => ['tipo_impuesto_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['fecha_expiracion', 'fecha_expedicion'], 'validarFechas']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor_impuesto' => 'Valor impuesto',
            'fecha_expedicion' => 'Fecha expedicion',
            'fecha_expiracion' => 'Fecha expiracion',
            'descripcion' => 'Descripcion',
            'vehiculo_id' => 'Vehiculo',
            'centro_costo_id' => 'Centro de costos',
            'tipo_impuesto_id' => 'Tipo de impuesto',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa',
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
    public function getCentroCosto()
    {
        return $this->hasOne(CentrosCostos::className(), ['id' => 'centro_costo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoImpuesto()
    {
        return $this->hasOne(TiposImpuestos::className(), ['id' => 'tipo_impuesto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['id' => 'empresa_id']);
    }
    /* Esta funcion se usara para la validacion entre los 
        rangos de las fechas de expedicion, vigencia y expiracion del seguro
    */
    public function validarFechas()
    {
        $fechaExpedicion = strtotime($this->fecha_expedicion);
        $fechaExpiracion = strtotime($this->fecha_expiracion);
        
        $error = null;
        if (!empty($fechaExpedicion) && !empty($fechaExpiracion)) {
            if ($fechaExpiracion < $fechaExpedicion) {
                $error = 'La fecha de expiracion no puede ser menor que la fecha de expedicion.';
                $this->addError('fecha_expiracion', $error);
            }
            if ($fechaExpiracion == $fechaExpedicion) {
                $error = 'La fecha de expiracion no puede ser igual a la fecha de expedicion.';
                $this->addError('fecha_expiracion', $error);
            }
        }
        
    
    }
}
