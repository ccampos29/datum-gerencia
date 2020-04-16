<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;
use common\models\User;

/**
 * This is the model class for table "ordenes_trabajos_repuestos".
 *
 * @property int $id
 * @property int $orden_trabajo_id Es el dato intermedio de orden de trabajo
 * @property int|null $repuesto_id Es el dato intermedio del repuesto
 * @property int $proveedor_id Dato intermedio del proveedor
 * @property int|null $costo_unitario Es el valor del repuesto segun el proveedor
 * @property int|null $impuesto_id Es el impuesto que se le aplica al repuesto
 * @property int|null $descuento Es el descuento que se le aplica al repuesto
 * @property string $tipo_descuento Especifica si el descuento es en valor($) o en porcentaje(%)
 * @property int|null $empresa_id Relación con empresa
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property Empresas $empresa
 * @property OrdenesTrabajos $ordenTrabajo
 * @property Repuestos $repuesto
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Proveedores $proveedor
 */
class OrdenesTrabajosRepuestos extends MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajos_repuestos';
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
            [['orden_trabajo_id', 'proveedor_id', 'costo_unitario', 'cantidad'], 'required'],
            [['orden_trabajo_id', 'repuesto_id', 'proveedor_id', 'cantidad', 'empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['costo_unitario'], 'number'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['orden_trabajo_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenesTrabajos::className(), 'targetAttribute' => ['orden_trabajo_id' => 'id']],
            [['repuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repuestos::className(), 'targetAttribute' => ['repuesto_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orden_trabajo_id' => 'Orden Trabajo ',
            'repuesto_id' => 'Repuesto ',
            'proveedor_id' => 'Proveedor ',
            'costo_unitario' => 'Costo Unitario',
            'cantidad' => 'Cantidad',
            'empresa_id' => 'Empresa ID',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
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
    public function getOrdenTrabajo()
    {
        return $this->hasOne(OrdenesTrabajos::className(), ['id' => 'orden_trabajo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepuesto()
    {
        return $this->hasOne(Repuestos::className(), ['id' => 'repuesto_id']);
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
    public function getProveedor()
    {
        return $this->hasOne(Proveedores::className(), ['id' => 'proveedor_id']);
    }

    /**
     * Suma el valor del repuesto a la orden
     * @param array $idOrden, $valor
     */
    public function sumarValorOrdenTrabajo($idOrden, $valor, $cantidad)
    {
        $orden = OrdenesTrabajos::findOne($idOrden);
        $valor2 = $valor * $cantidad;
        $orden->total_valor_repuesto = $orden->total_valor_repuesto  + $valor2;
        $orden->save();
    }

    /**
     * Resta el valor del repuesto a la orden
     * @param array $idOrden, $valor
     */
    public function restarValorOrdenTrabajo($idOrden, $valor, $cantidad)
    {
        $orden = OrdenesTrabajos::findOne($idOrden);
        $valor2 = $valor * $cantidad;
        $orden->total_valor_repuesto = $orden->total_valor_repuesto - $valor2;
        $orden->save();
    }

    /**
     * Actualiza el valor del repuesto a la orden
     * @param array $idOrden, $valor, $valorViejo
     */
    public function actualizarValorOrdenTrabajo($idOrden, $valor,$cantidad, $valorViejo)
    {
        $orden = OrdenesTrabajos::findOne($idOrden);
        $valor2 = $valor * $cantidad;
        $orden->total_valor_repuesto = $orden->total_valor_repuesto - $valorViejo;
        $orden->total_valor_repuesto = $orden->total_valor_repuesto + $valor2;
        $orden->save();
    }
}
