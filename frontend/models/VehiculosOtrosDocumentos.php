<?php

namespace frontend\models;
use common\models\User;
use common\models\MyActiveRecord;
use Yii;

/**
 * This is the model class for table "vehiculos_otros_documentos".
 *
 * @property int $id
 * @property string|null $codigo Codigo para el documento
 * @property float $valor_unitario Valor del documento
 * @property string $fecha_vigencia Fecha inicial de la vigencia del documento
 * @property string $fecha_expedicion Fecha de expedicion del documento
 * @property string $fecha_expiracion Fecha de expiracion del documento
 * @property string|null $descripcion Descripción del documento
 * @property int $vehiculo_id Dato intermedio entre vehiculos_impuestos y vehiculos
 * @property int $centro_costo_id Dato intermedio entre otros_documentos y centros_costos
 * @property int $tipo_documento_id Dato intermedio entre otros_documentos y tipos_documentos
 * @property int $proveedor_id Dato intermedio entre otros_documentos y proveedores
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 *
 * @property Vehiculos $vehiculo
 * @property CentrosCostos $centroCosto
 * @property TiposOtrosDocumentos $tipoDocumento
 * @property Proveedores $proveedor
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Empresas $empresa
 */
class VehiculosOtrosDocumentos extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehiculos_otros_documentos';
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
            [['valor_unitario', 'fecha_vigencia', 'fecha_expedicion', 'fecha_expiracion', 'vehiculo_id', 'centro_costo_id', 'tipo_documento_id', 'proveedor_id'], 'required'],
            [['valor_unitario'], 'number'],
            [['fecha_vigencia', 'fecha_expedicion', 'fecha_expiracion', 'creado_el', 'actualizado_el'], 'safe'],
            [['descripcion'], 'string'],
            [['vehiculo_id', 'centro_costo_id', 'tipo_documento_id', 'proveedor_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['codigo'], 'string', 'max' => 20],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['centro_costo_id'], 'exist', 'skipOnError' => true, 'targetClass' => CentrosCostos::className(), 'targetAttribute' => ['centro_costo_id' => 'id']],
            [['tipo_documento_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposOtrosDocumentos::className(), 'targetAttribute' => ['tipo_documento_id' => 'id']],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
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
            'codigo' => 'Codigo',
            'valor_unitario' => 'Valor unitario',
            'fecha_vigencia' => 'Fecha vigencia',
            'fecha_expedicion' => 'Fecha expedicion',
            'fecha_expiracion' => 'Fecha expiracion',
            'descripcion' => 'Descripcion',
            'vehiculo_id' => 'Vehiculo',
            'centro_costo_id' => 'Centro de costos',
            'tipo_documento_id' => 'Tipo del documento',
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
    public function getTipoDocumento()
    {
        return $this->hasOne(TiposOtrosDocumentos::className(), ['id' => 'tipo_documento_id']);
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
