<?php

namespace frontend\models;
use common\models\User;
use common\models\MyActiveRecord;
use Yii;

/**
 * This is the model class for table "vehiculos_seguros".
 *
 * @property int $id
 * @property string $numero_poliza Numero o codigo del seguro
 * @property float $valor_seguro Valor del seguro
 * @property string $fecha_vigencia Fecha inicial de la vigencia del seguro
 * @property string $fecha_expedicion Fecha de expedicion del seguro
 * @property string $fecha_expiracion Fecha de expiracion del seguro
 * @property int $vehiculo_id Dato intermedio entre vehiculos_impuestos y vehiculos
 * @property int $centro_costo_id Dato intermedio entre vehiculos_seguros y centros_costos
 * @property int $tipo_seguro_id Dato intermedio entre vehiculos_seguros y tipos_seguros
 * @property int $proveedor_id Dato intermedio entre vehiculos_seguros y proveedores
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
 * @property TiposSeguros $tipoSeguro
 * @property Proveedores $proveedor
 * @property Empresas $empresa
 */
class VehiculosSeguros extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehiculos_seguros';
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
            [['numero_poliza', 'valor_seguro', 'fecha_vigencia', 'fecha_expedicion', 'fecha_expiracion', 'vehiculo_id', 'centro_costo_id', 'tipo_seguro_id', 'proveedor_id'], 'required'],
            [['valor_seguro'], 'number'],
            [['fecha_vigencia', 'fecha_expedicion', 'fecha_expiracion', 'creado_el', 'actualizado_el'], 'safe'],
            [['vehiculo_id', 'centro_costo_id', 'tipo_seguro_id', 'proveedor_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['numero_poliza'], 'string', 'max' => 20],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['centro_costo_id'], 'exist', 'skipOnError' => true, 'targetClass' => CentrosCostos::className(), 'targetAttribute' => ['centro_costo_id' => 'id']],
            [['tipo_seguro_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposSeguros::className(), 'targetAttribute' => ['tipo_seguro_id' => 'id']],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['fecha_vigencia', 'fecha_expiracion', 'fecha_expedicion'], 'validarFechas']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numero_poliza' => 'Numero de poliza',
            'valor_seguro' => 'Valor del seguro',
            'fecha_vigencia' => 'Fecha de vigencia',
            'fecha_expedicion' => 'Fecha de expedicion',
            'fecha_expiracion' => 'Fecha de expiracion',
            'vehiculo_id' => 'Vehiculo',
            'centro_costo_id' => 'Centro de costos',
            'tipo_seguro_id' => 'Tipo del seguro',
            'proveedor_id' => 'Proveedor',
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
    public function getTipoSeguro()
    {
        return $this->hasOne(TiposSeguros::className(), ['id' => 'tipo_seguro_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedor()
    {
        return $this->hasOne(Proveedores::className(), ['id' => 'proveedor_id']);
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
        $fechaVigencia = strtotime($this->fecha_vigencia);

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
        if (!empty($fechaVigencia) && !empty($fechaExpiracion)) {
            if ($fechaVigencia < $fechaExpedicion) {
                $error = 'La fecha de vigencia no puede ser menor que la fecha de expedicion.';
                $this->addError('fecha_vigencia', $error);
            }
            /*if ($fechaVigencia == $fechaExpedicion) {
                $error = 'La fecha de vigencia no puede ser igual a la fecha de expedicion.';
                $this->addError('fecha_vigencia', $error);
            }*/
        }
    
    }
}
