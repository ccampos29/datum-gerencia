<?php

namespace frontend\models;

use common\models\User;
use common\models\MyActiveRecord;
use Yii;

/**
 * This is the model class for table "otros_gastos".
 *
 * @property int $id
 * @property string $factura Codigo/numero de la factura
 * @property string $codigo_interno Codigo interno que genera cada empresa
 * @property string $fecha Fecha de registro del gasto
 * @property int $valor_unitario Valor unitario del gasto
 * @property int $cantidad_unitaria Cantidad unitaria del gasto
 * @property int $vehiculo_id Dato intermedio entre otros_gastos y vehiculos
 * @property int $tipo_gasto_id Dato intermedio entre otros_gastos y tipos_gastos
 * @property int $tipo_descuento_id Dato intermedio entre otros_gastos y tipos_descuentos
 * @property int $impuesto_id Dato intermedio entre otros_gastos y impuestos
 * @property string $observacion Observación del gasto cargado
 * @property int $cargo_empleado_id Dato intermedio entre otros_gastos y empleados
 * @property int $proveedor_id Dato intermedio entre otros_gastos y proveedores
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property TiposImpuestos $impuesto
 * @property Proveedor $proveedor
 * @property TiposDescuentos $tipoDescuento
 * @property TiposGastos $tipoGasto
 * @property Vehiculos $vehiculo
 */
class OtrosGastos extends \common\models\MyActiveRecord
{
    public $gastos;
    public $total_cost;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'otros_gastos';
    }
    /**
     * Registra y/o Modifica la empresa en el modelo, según la empresa del usuario logueado
     * @param string $insert Query de inserción
     * @return mixed[]
     */
    public function beforeSave($insert)
    {
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
            [['vehiculo_id', 'fecha','tipo_gasto_id', 'tipo_descuento', 'tipo_impuesto_id', 'usuario_id', 'proveedor_id', 'valor_unitario'], 'required'],
            [['fecha', 'creado_el', 'actualizado_el'], 'safe'],
            [['valor_unitario', 'cantidad_unitaria', 'vehiculo_id', 'tipo_gasto_id', 'tipo_impuesto_id', 'usuario_id', 'proveedor_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['tipo_descuento', 'observacion'], 'string'],
            [['cantidad_descuento'], 'number'],
            [['factura', 'codigo_interno'], 'string', 'max' => 355],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['tipo_gasto_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposGastos::className(), 'targetAttribute' => ['tipo_gasto_id' => 'id']],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['tipo_impuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposImpuestos::className(), 'targetAttribute' => ['tipo_impuesto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'factura' => 'Factura',
            'codigo_interno' => 'Codigo interno',
            'fecha' => 'Fecha de gasto',
            'valor_unitario' => 'Valor unitario',
            'cantidad_unitaria' => 'Cantidad unitaria',
            'vehiculo_id' => 'Vehiculo',
            'tipo_gasto_id' => 'Tipo del gasto',
            'tipo_descuento' => 'Tipo de descuento',
            'cantidad_descuento' => 'Cantidad Descuento',
            'tipo_impuesto_id' => 'Impuesto sobre el gasto',
            'observacion' => 'Observacion',
            'usuario_id' => 'Cargar a',
            'proveedor_id' => 'Proveedor',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
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
    public function getTipoImpuesto()
    {
        return $this->hasOne(TiposImpuestos::className(), ['id' => 'tipo_impuesto_id']);
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
    public function getTipoGasto()
    {
        return $this->hasOne(TiposGastos::className(), ['id' => 'tipo_gasto_id']);
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id']);
    }

    /**
     * Asocia los trabajos a las rutinas
     * @param array $trabajos
     */
    public function asociarGrupos($gastos)
    {
        
        if (!empty($gastos)) {
            $cantidad_descuento = $gastos;
        }
    }
}
