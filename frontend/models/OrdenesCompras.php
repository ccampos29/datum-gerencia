<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "ordenes_compras".
 *
 * @property int $id
 * @property string $fecha_hora_orden Es la fecha y hora de la orden de compra
 * @property int $proveedor_id Dato del proveedor que se le va a comprar
 * @property string $forma_pago Indica la forma de pago de la compra
 * @property string $direccion Es la direccion a donde se entregará la orden
 * @property string $observacion Es una pequeña descripcion de la orden
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relacion con Empresa
 *
 * @property User $actualizadoPor
 * @property Empresas $empresa
 * @property Proveedores $proveedor
 * @property User $creadoPor
 * @property OrdenesComprasRepuestos[] $ordenesComprasRepuestos
 */
class OrdenesCompras extends MyActiveRecord
{

    public $repuestos;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_compras';
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
            [['fecha_hora_orden', 'proveedor_id'], 'required'],
            [['fecha_hora_orden', 'creado_el', 'actualizado_el'], 'safe'],
            [['proveedor_id', 'consecutivo', 'estado', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['forma_pago', 'direccion', 'proviene_de'], 'string', 'max' => 255],
            [['observacion'], 'string', 'max' => 355],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            ['repuestos', 'validarRepuestos'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'consecutivo' => 'Orden N°',
            'fecha_hora_orden' => 'Fecha Hora Orden',
            'proveedor_id' => 'Proveedor',
            'forma_pago' => 'Forma Pago',
            'direccion' => 'Direccion',
            'estado' => 'Estado',
            'observacion' => 'Observacion',
            'proviene_de' => 'Proviene de',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
        ];
    }

    /**
     * Gets query for [[Proveedor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProveedor()
    {
        return $this->hasOne(Proveedores::className(), ['id' => 'proveedor_id']);
    }

    /**
     * Gets query for [[Empresa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['id' => 'empresa_id']);
    }

    /**
     * Gets query for [[CreadoPor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
    }

    /**
     * Gets query for [[ActualizadoPor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActualizadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }

    /**
     * Gets query for [[OrdenesComprasRepuestos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesComprasRepuestos()
    {
        return $this->hasMany(OrdenesComprasRepuestos::className(), ['orden_compra_id' => 'id']);
    }

    /**
     * Asocia los repuestos a las ordenes de compra
     * @param array $repuestos
     */
    public function asociarRepuestos($repuestos)
    {
        if(!empty($this->ordenesComprasRepuestos)){
            $this->eliminarRepuestos($this->id);
        }
        foreach ($repuestos as $repuesto) {
            $ordenCompraRepuesto = new OrdenesComprasRepuestos();
            $ordenCompraRepuesto->orden_compra_id = $this->id;
            $ordenCompraRepuesto->repuesto_id = $repuesto['repuesto_id'];
            $ordenCompraRepuesto->cantidad = $repuesto['cantidad'];
            $ordenCompraRepuesto->valor_unitario = $repuesto['valor_unitario'];
            $ordenCompraRepuesto->tipo_descuento = $repuesto['tipo_descuento'];
            $ordenCompraRepuesto->descuento_unitario = $repuesto['descuento_unitario'];
            $ordenCompraRepuesto->tipo_impuesto_id = $repuesto['tipo_impuesto_id'];
            $ordenCompraRepuesto->observacion = $repuesto['observacion'];
            if (!$ordenCompraRepuesto->save()) {
                print_r($ordenCompraRepuesto->getErrors());
                die();
            }
        }
    }

    /**
     * Elimina los repuestos a la orden de compra
     * @param array $id
     */
    public function eliminarRepuestos($id)
    {
        $model = OrdenesCompras::findOne($id);
        $repuestos = $model->ordenesComprasRepuestos;

        foreach ($repuestos as $repuesto) {
            $repuesto->delete();
        }
    }

    public function antesDelete()
    {
        $model = OrdenesCompras::findOne($this->id);
        $repuestos = $model->ordenesComprasRepuestos;

        foreach ($repuestos as $repuesto) {
            $repuesto->delete();
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->repuestos = $this->ordenesComprasRepuestos;
    }



    public function validarRepuestos()
    {
        foreach ($this->repuestos as $indexRepuesto => $repuesto) {
            if (empty($repuesto['repuesto_id'])) {
                $error = '"Repuesto" no puede estar vacio.';
                $this->addError('repuestos[' . $indexRepuesto . '][repuesto_id]', $error);
            }
            if (empty($repuesto['cantidad'])) {
                $error = '"Cantidad" no puede estar vacio.';
                $this->addError('repuestos[' . $indexRepuesto . '][cantidad]', $error);
            }
            if (empty($repuesto['valor_unitario'])) {
                $error = 'Valor unitario no puede estar vacio.';
                $this->addError('repuestos[' . $indexRepuesto . '][valor_unitario]', $error);
            }
            if ($repuesto['descuento_unitario'] === null) {
                $error = 'Descuento unitario no puede ir vacio.';
                $this->addError('repuestos[' . $indexRepuesto . '][descuento_unitario]', $error);
            }
            if (empty($repuesto['observacion'])) {
                $error = 'La observación no puede ir vacia.';
                $this->addError('repuestos[' . $indexRepuesto . '][observacion]', $error);
            }
        }
    }
}
