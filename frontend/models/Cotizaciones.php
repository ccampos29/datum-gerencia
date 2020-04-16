<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "cotizaciones".
 *
 * @property int $id
 * @property string $fecha_hora_cotizacion Es la fecha y hora de la cotizacion
 * @property int $solicitud_id Dato de la solicitud que se le va a cotizar
 * @property int $proveedor_id Dato del proveedor que se le va a cotizar
 * @property string $fecha_hora_vigencia Es la fecha y hora de vigencia de la cotizacion
 * @property string $observacion Es una pequeña descripcion de la cotizacion
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
 * @property Solicitudes $solicitud
 * @property CotizacionesRepuestos[] $cotizacionesRepuestos
 * @property CotizacionesTrabajos[] $cotizacionesTrabajos
 */
class Cotizaciones extends MyActiveRecord
{
    public $repuestos;
    public $trabajos;
    public $tipo;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cotizaciones';
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
        return parent::find()->andFilterWhere(['empresa_id' => @Yii::$app->user->identity->empresa_id]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_hora_cotizacion', 'solicitud_id', 'proveedor_id', 'fecha_hora_vigencia', 'estado'], 'required'],
            [['fecha_hora_cotizacion', 'fecha_hora_vigencia', 'creado_el', 'actualizado_el'], 'safe'],
            [['solicitud_id', 'proveedor_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['estado'], 'string'],
            [['observacion'], 'string', 'max' => 355],
            [['solicitud_id'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitudes::className(), 'targetAttribute' => ['solicitud_id' => 'id']],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['trabajos', 'repuestos'], 'validaciones'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_hora_cotizacion' => 'Fecha Hora Cotizacion',
            'solicitud_id' => 'Solicitud',
            'proveedor_id' => 'Proveedor',
            'fecha_hora_vigencia' => 'Fecha Hora Vigencia',
            'observacion' => 'Observacion',
            'estado' => 'Estado',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
        ];
    }

    /**
     * Gets query for [[Solicitud]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitud()
    {
        return $this->hasOne(Solicitudes::className(), ['id' => 'solicitud_id']);
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
     * Gets query for [[CotizacionesRepuestos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacionesRepuestos()
    {
        return $this->hasMany(CotizacionesRepuestos::className(), ['cotizacion_id' => 'id']);
    }

    /**
     * Gets query for [[CotizacionesTrabajos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacionesTrabajos()
    {
        return $this->hasMany(CotizacionesTrabajos::className(), ['cotizacion_id' => 'id']);
    }


    /**
     * Asocia los items a la cotizacion
     * @param array $trabajos
     */
    public function asociarItems($idSolicitud)
    {
        $solicitud = Solicitudes::findOne($idSolicitud);
        if ($solicitud->tipo == "Repuestos") {
            $repuestosSolicitudes = SolicitudesRepuestos::find()->where(['solicitud_id' => $idSolicitud])->all();
            foreach ($repuestosSolicitudes as $indexRepuesto => $repuestoSolicitud) {
                $this->repuestos[$indexRepuesto]['repuesto_id'] = $repuestoSolicitud->repuesto_id;
                $this->repuestos[$indexRepuesto]['repuesto-mostrar'] = $repuestoSolicitud->repuesto_id;
                $this->repuestos[$indexRepuesto]['observacion_cliente'] = $repuestoSolicitud->observacion;
                $this->repuestos[$indexRepuesto]['cantidad'] = $repuestoSolicitud->cantidad;
            }
        } else {
            $trabajosSolicitud = SolicitudesTrabajos::find()->where(['solicitud_id' => $idSolicitud])->all();
            foreach ($trabajosSolicitud as $indexTrabajo => $trabajoSolicitud) {
                $this->trabajos[$indexTrabajo]['trabajo_id'] = $trabajoSolicitud->trabajo_id;
                $this->trabajos[$indexTrabajo]['trabajo-mostrar'] = $trabajoSolicitud->trabajo_id;
                $this->trabajos[$indexTrabajo]['observacion_cliente'] = $trabajoSolicitud->observacion;
                $this->trabajos[$indexTrabajo]['cantidad'] = $trabajoSolicitud->cantidad;
            }
        }
    }

    /**
     * Asocia los repuestos a la cotizacion
     * @param array $repuestos
     */
    public function asociarRepuestos($repuestos)
    {
        $this->eliminarRepuestos($this->id);
        foreach ($repuestos as $repuesto) {
            $cotizacionRepuesto = new CotizacionesRepuestos();
            $cotizacionRepuesto->cotizacion_id = $this->id;
            $cotizacionRepuesto->repuesto_id = $repuesto['repuesto_id'];
            $cotizacionRepuesto->cantidad = $repuesto['cantidad'];
            $cotizacionRepuesto->observacion_cliente = $repuesto['observacion_cliente'];
            $cotizacionRepuesto->valor_unitario = $repuesto['valor_unitario'];
            $cotizacionRepuesto->tipo_descuento = $repuesto['tipo_descuento'];
            $cotizacionRepuesto->descuento_unitario = $repuesto['descuento_unitario'];
            $cotizacionRepuesto->tipo_impuesto_id = $repuesto['tipo_impuesto_id'];
            $cotizacionRepuesto->observacion = $repuesto['observacion'];
            if (!$cotizacionRepuesto->save()) {
                print_r($cotizacionRepuesto->getErrors());
                die();
            }
        }
    }


    /**
     * Asocia los trabajos a la cotizacion
     * @param array $trabajos
     */
    public function asociarTrabajos($trabajos)
    {
        $this->eliminarTrabajos($this->id);
        foreach ($trabajos as $trabajo) {
            $cotizacionTrabajo = new CotizacionesTrabajos();
            $cotizacionTrabajo->cotizacion_id = $this->id;
            $cotizacionTrabajo->trabajo_id = $trabajo['trabajo_id'];
            $cotizacionTrabajo->cantidad = $trabajo['cantidad'];
            $cotizacionTrabajo->observacion_cliente = $trabajo['observacion_cliente'];
            $cotizacionTrabajo->valor_unitario = $trabajo['valor_unitario'];
            $cotizacionTrabajo->tipo_descuento = $trabajo['tipo_descuento'];
            $cotizacionTrabajo->descuento_unitario = $trabajo['descuento_unitario'];
            $cotizacionTrabajo->tipo_impuesto_id = $trabajo['tipo_impuesto_id'];
            $cotizacionTrabajo->observacion = $trabajo['observacion'];
            if (!$cotizacionTrabajo->save()) {
                print_r($cotizacionTrabajo->getErrors());
                die();
            }
        }
    }

    /**
     * Elimina los repuestos a la cotizacion
     * @param array $id
     */
    public function eliminarRepuestos($id)
    {
        $model = Cotizaciones::findOne($id);
        $repuestos = $model->cotizacionesRepuestos;

        foreach ($repuestos as $repuesto) {
            $repuesto->delete();
        }
    }

    /**
     * Elimina los trabajos a la cotizacion
     * @param array $id
     */
    public function eliminarTrabajos($id)
    {
        $model = Cotizaciones::findOne($id);
        $trabajos = $model->cotizacionesTrabajos;

        foreach ($trabajos as $trabajo) {
            $trabajo->delete();
        }
    }

    public function antesDelete()
    {
        $model = Cotizaciones::findOne($this->id);
        $repuestos = $model->cotizacionesRepuestos;

        foreach ($repuestos as $repuesto) {
            $repuesto->delete();
        }

        $trabajos = $model->cotizacionesTrabajos;

        foreach ($trabajos as $trabajo) {
            $trabajo->delete();
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        foreach ($this->cotizacionesRepuestos as $indexRepuesto => $cotizacionRepuesto) {
            $this->repuestos[$indexRepuesto]['repuesto_id'] = $cotizacionRepuesto->repuesto_id;
            $this->repuestos[$indexRepuesto]['repuesto-mostrar'] = $cotizacionRepuesto->repuesto_id;
            $this->repuestos[$indexRepuesto]['observacion_cliente'] = $cotizacionRepuesto->observacion_cliente;
            $this->repuestos[$indexRepuesto]['cantidad'] = $cotizacionRepuesto->cantidad;
            $this->repuestos[$indexRepuesto]['valor_unitario'] = $cotizacionRepuesto->valor_unitario;
            $this->repuestos[$indexRepuesto]['tipo_descuento'] = $cotizacionRepuesto->tipo_descuento;
            $this->repuestos[$indexRepuesto]['descuento_unitario'] = $cotizacionRepuesto->descuento_unitario;
            $this->repuestos[$indexRepuesto]['tipo_impuesto_id'] = $cotizacionRepuesto->tipo_impuesto_id;
            $this->repuestos[$indexRepuesto]['observacion'] = $cotizacionRepuesto->observacion;
        }
        foreach ($this->cotizacionesTrabajos as $indexTrabajo => $cotizacionTrabajo) {
            $this->trabajos[$indexTrabajo]['trabajo_id'] = $cotizacionTrabajo->trabajo_id;
            $this->trabajos[$indexTrabajo]['trabajo-mostrar'] = $cotizacionTrabajo->trabajo_id;
            $this->trabajos[$indexTrabajo]['observacion_cliente'] = $cotizacionTrabajo->observacion_cliente;
            $this->trabajos[$indexTrabajo]['cantidad'] = $cotizacionTrabajo->cantidad;
            $this->trabajos[$indexTrabajo]['valor_unitario'] = $cotizacionTrabajo->valor_unitario;
            $this->trabajos[$indexTrabajo]['tipo_descuento'] = $cotizacionTrabajo->tipo_descuento;
            $this->trabajos[$indexTrabajo]['descuento_unitario'] = $cotizacionTrabajo->descuento_unitario;
            $this->trabajos[$indexTrabajo]['tipo_impuesto_id'] = $cotizacionTrabajo->tipo_impuesto_id;
            $this->trabajos[$indexTrabajo]['observacion'] = $cotizacionTrabajo->observacion;
        }
    }

    public function validaciones()
    {
        if ($this->solicitud->tipo == 'Repuestos') {
            foreach ($this->repuestos as $indexRepuesto => $repuesto) {
                if (empty($repuesto['repuesto_id'])) {
                    $error = '"Repuesto" no puede estar vacio.';
                    $this->addError('repuestos[' . $indexRepuesto . '][repuesto-mostrar]', $error);
                }
                if (empty($repuesto['observacion_cliente'])) {
                    $error = '"Observacion del Cliente" no puede estar vacio.';
                    $this->addError('repuestos[' . $indexRepuesto . '][observacion_cliente]', $error);
                }
                if (empty($repuesto['cantidad'])) {
                    $error = '"Cantidad" no puede estar vacio.';
                    $this->addError('repuestos[' . $indexRepuesto . '][cantidad]', $error);
                }
                if (empty($repuesto['valor_unitario'])) {
                    $error = '"Valor Unitario" no puede estar vacio.';
                    $this->addError('repuestos[' . $indexRepuesto . '][valor_unitario]', $error);
                }
                if (empty($repuesto['tipo_descuento'])) {
                    $error = '"Tipo Descuento" no puede estar vacio.';
                    $this->addError('repuestos[' . $indexRepuesto . '][tipo_descuento]', $error);
                }
                if ($repuesto['descuento_unitario'] === null) {
                    $error = '"Descuento Unitario" no puede estar vacio.';
                    $this->addError('repuestos[' . $indexRepuesto . '][descuento_unitario]', $error);
                }
                if (empty($repuesto['tipo_impuesto_id'])) {
                    $error = '"Tipo Impuesto" no puede estar vacio.';
                    $this->addError('repuestos[' . $indexRepuesto . '][tipo_impuesto_id]', $error);
                }
                if (empty($repuesto['observacion'])) {
                    $error = 'La observación no puede ir vacia.';
                    $this->addError('repuestos[' . $indexRepuesto . '][observacion]', $error);
                }
            }
        } else {
            foreach ($this->trabajos as $indexTrabajo => $trabajo) {
                if (empty($trabajo['trabajo_id'])) {
                    $error = '"Trabajo" no puede estar vacio.';
                    $this->addError('trabajos[' . $indexTrabajo . '][trabajo-mostrar]', $error);
                }
                if (empty($trabajo['observacion_cliente'])) {
                    $error = '"Observacion del Cliente" no puede estar vacio.';
                    $this->addError('trabajos[' . $indexTrabajo . '][observacion_cliente]', $error);
                }
                if (empty($trabajo['cantidad'])) {
                    $error = '"Cantidad" no puede estar vacio.';
                    $this->addError('trabajos[' . $indexTrabajo . '][cantidad]', $error);
                }
                if (empty($trabajo['valor_unitario'])) {
                    $error = '"Valor Unitario" no puede estar vacio.';
                    $this->addError('trabajos[' . $indexTrabajo . '][valor_unitario]', $error);
                }
                if (empty($trabajo['tipo_descuento'])) {
                    $error = '"Tipo Descuento" no puede estar vacio.';
                    $this->addError('trabajos[' . $indexTrabajo . '][tipo_descuento]', $error);
                }
                if ($trabajo['descuento_unitario'] === null) {
                    $error = '"Descuento Unitario" no puede estar vacio.';
                    $this->addError('trabajos[' . $indexTrabajo . '][descuento_unitario]', $error);
                }
                if (empty($trabajo['tipo_impuesto_id'])) {
                    $error = '"Tipo Impuesto" no puede estar vacio.';
                    $this->addError('trabajos[' . $indexTrabajo . '][tipo_impuesto_id]', $error);
                }
                if (empty($trabajo['observacion'])) {
                    $error = 'La observación no puede ir vacia.';
                    $this->addError('trabajos[' . $indexTrabajo . '][observacion]', $error);
                }
            }
        }
    }
}
