<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "compras".
 *
 * @property int $id
 * @property int $proveedor_id Es el proveedor a quien se le comprará el repuesto
 * @property string $fecha_hora_hoy Es la fecha de cuando se realiza la compra
 * @property string $fecha_factura Es la fecha de cuando se esta facturando
 * @property int $numero_factura Es el numero de la factura de compra
 * @property string $fecha_radicado Es la fecha del radicado
 * @property string $fecha_remision Es la fecha de la remision
 * @property int $numero_remision Es el numero de la remision
 * @property int $estado Determina si la compra esta Abierta o Cerrada
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relacion con Empresa
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property Proveedores $proveedor
 * @property ComprasRepuestos[] $comprasRepuestos
 */
class Compras extends MyActiveRecord
{
    public $repuestos;

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
        return parent::find()->andFilterWhere(['empresa_id' => @Yii::$app->user->identity->empresa_id]);
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proveedor_id', 'fecha_hora_hoy', 'fecha_factura', 'numero_remision'], 'required'],
            [['proveedor_id', 'numero_factura', 'numero_remision', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['fecha_hora_hoy', 'fecha_factura', 'fecha_radicado', 'fecha_remision', 'creado_el', 'actualizado_el'], 'safe'],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['ubicacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => UbicacionesInsumos::className(), 'targetAttribute' => ['ubicacion_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [
                'repuestos',
                'validarRepuestos'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proveedor_id' => 'Proveedor',
            'ubicacion_id' => 'Ubicacion',
            'fecha_hora_hoy' => 'Fecha y hora Actual',
            'fecha_factura' => 'Fecha Factura',
            'numero_factura' => 'Numero Factura',
            'fecha_radicado' => 'Fecha Radicado',
            'fecha_remision' => 'Fecha Remision',
            'numero_remision' => 'Numero Remision',
            'estado' => 'Estado',
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
    public function getProveedor()
    {
        return $this->hasOne(Proveedores::className(), ['id' => 'proveedor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacion()
    {
        return $this->hasOne(UbicacionesInsumos::className(), ['id' => 'ubicacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComprasRepuestos()
    {
        return $this->hasMany(ComprasRepuestos::className(), ['compra_id' => 'id']);
    }

    /**
     * Asocia los repuestos a las compras
     * @param array $repuestos
     */
    public function asociarRepuestos($repuestos)
    {
        $this->eliminarRepuestos($this->id);
        foreach ($repuestos as $repuesto) {
            $compraRepuesto = new ComprasRepuestos();
            $compraRepuesto->compra_id = $this->id;
            $compraRepuesto->repuesto_id = $repuesto['repuesto_id'];
            $compraRepuesto->cantidad = $repuesto['cantidad'];
            $compraRepuesto->valor_unitario = $repuesto['valor_unitario'];
            $compraRepuesto->tipo_descuento = $repuesto['tipo_descuento'];
            $compraRepuesto->descuento_unitario = $repuesto['descuento_unitario'];
            $compraRepuesto->tipo_impuesto_id = $repuesto['tipo_impuesto_id'];
            if (!empty($repuesto['observacion'])) {
                $compraRepuesto->observacion = $repuesto['observacion'];
            } else {
                $compraRepuesto->observacion = null;
            }
            if (!$compraRepuesto->save()) {
                print_r($compraRepuesto->getErrors());
                die();
            }
        }
    }

    public function asociarItems($orden)
    {
        $repuestosOrden = OrdenesComprasRepuestos::find()->where(['orden_compra_id' => $orden->id])->all();
        foreach ($repuestosOrden as $indexRepuesto => $repuestoOrden) {
            $this->repuestos[$indexRepuesto]['repuesto_id'] = $repuestoOrden->repuesto_id;
            $this->repuestos[$indexRepuesto]['cantidad'] = $repuestoOrden->cantidad;
            $this->repuestos[$indexRepuesto]['valor_unitario'] = $repuestoOrden->valor_unitario;
            $this->repuestos[$indexRepuesto]['tipo_descuento'] = $repuestoOrden->tipo_descuento;
            $this->repuestos[$indexRepuesto]['descuento_unitario'] = $repuestoOrden->descuento_unitario;
            $this->repuestos[$indexRepuesto]['tipo_impuesto_id'] = $repuestoOrden->tipo_impuesto_id;
        }
    }

    /**
     * Elimina los repuestos a la compra
     * @param array $id
     */
    public function eliminarRepuestos($id)
    {
        $model = Compras::findOne($id);
        $repuestos = $model->comprasRepuestos;

        foreach ($repuestos as $repuesto) {
            $repuesto->delete();
        }
    }

    public function antesDelete()
    {
        $model = Compras::findOne($this->id);
        $repuestos = $model->comprasRepuestos;

        foreach ($repuestos as $repuesto) {
            $repuesto->delete();
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->repuestos = $this->comprasRepuestos;
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
        }
    }
}
