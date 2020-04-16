<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "ordenes_trabajos".
 *
 * @property int $id
 * @property int $vehiculo_id Es la referencia del vehiculo
 * @property string $fecha_ingreso Es la fecha de cuando ingreso el vehiculo
 * @property string $hora_ingreso Es la hora de cuando ingreso el vehiculo
 * @property string $fecha_orden Es la fecha de cuando se hizo la orden
 * @property string $hora_orden Es la hora de cuando se hizo la orden
 * @property string $fecha_cierre Es la fecha de cuando se entrega el vehiculo
 * @property string $hora_cierre Es la hora de cuando se entrega el vehiculo
 * @property int $medicion Es el kilometraje del odometro
 * @property int $proveedor_id Es el dato del proveedor
 * @property int $disponibilidad Determina si afecta la disponibilidad
 * @property string $observacion Describe como fue la orden de trabajo
 * @property int $tipo_orden_id Determina el tipo de orden de trabajo
 * @property int $estado_orden Determina si la orden estaba abierta o cerrada
 * @property int $usuario_conductor_id Es el conductor del vehiculo
 * @property int $etiqueta_mantenimiento_id Es la etiqueta del mantenimiento para ayudar con filtros
 * @property int $centro_costo_id Es el centro de costo de donde viene la orden
 * @property int $departamento_id Es el departamento donde se esta haciendo la orden
 * @property int $municipio_id Es el municipio donde se esta haciendo la orden
 * @property int $grupo_vehiculo_id Es el grupo del vehiculo que se atendio
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property Vehiculos $vehiculo
 * @property User $actualizadoPor
 * @property Departamentos $departamento
 * @property User $usuarioConductor
 * @property TiposOrdenes $tipoOrden
 * @property Proveedores $proveedor
 * @property Municipios $municipio
 * @property GruposVehiculos $grupoVehiculo
 * @property EtiquetasMantenimientos $etiquetaMantenimiento
 * @property CentrosCostos $centroCosto
 * @property User $creadoPor
 */
class OrdenesTrabajos extends MyActiveRecord
{

    public $repuestos;
    public $trabajos;
    public $total_valor_repuesto;
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
        return parent::find()->andFilterWhere(['ordenes_trabajos.empresa_id' => @Yii::$app->user->identity->empresa_id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehiculo_id', 'fecha_hora_orden', 'fecha_hora_cierre', 'proveedor_id', 'consecutivo', 'tipo_orden_id'], 'required'],
            [['vehiculo_id', 'medicion', 'proveedor_id', 'disponibilidad', 'tipo_orden_id', 'estado_orden', 'usuario_conductor_id', 'etiqueta_mantenimiento_id', 'centro_costo_id', 'departamento_id', 'municipio_id', 'grupo_vehiculo_id', 'consecutivo', 'total_valor_trabajo', 'total_valor_repuesto', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['fecha_hora_ingreso', 'fecha_hora_orden', 'fecha_hora_cierre', 'creado_el', 'actualizado_el'], 'safe'],
            [['observacion'], 'string', 'max' => 355],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['tipo_orden_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposOrdenes::className(), 'targetAttribute' => ['tipo_orden_id' => 'id']],
            [['usuario_conductor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_conductor_id' => 'id']],
            [['etiqueta_mantenimiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => EtiquetasMantenimientos::className(), 'targetAttribute' => ['etiqueta_mantenimiento_id' => 'id']],
            [['centro_costo_id'], 'exist', 'skipOnError' => true, 'targetClass' => CentrosCostos::className(), 'targetAttribute' => ['centro_costo_id' => 'id']],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamentos::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['municipio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Municipios::className(), 'targetAttribute' => ['municipio_id' => 'id']],
            [['grupo_vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => GruposVehiculos::className(), 'targetAttribute' => ['grupo_vehiculo_id' => 'id']],
            [['fecha_hora_ingreso', 'fecha_hora_orden', 'fecha_hora_cierre'], 'validarFechas'],
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
            'fecha_hora_ingreso' => 'Fecha Hora Ingreso',
            'fecha_hora_orden' => 'Fecha Hora Orden',
            'fecha_hora_cierre' => 'Fecha Hora Cierre',
            'medicion' => 'Medicion',
            'proveedor_id' => 'Proveedor',
            'disponibilidad' => 'Disponibilidad',
            'observacion' => 'Observacion',
            'tipo_orden_id' => 'Tipo Orden',
            'estado_orden' => 'Estado Orden',
            'usuario_conductor_id' => 'Usuario Conductor ID',
            'etiqueta_mantenimiento_id' => 'Etiqueta Mantenimiento ID',
            'centro_costo_id' => 'Centro Costo ID',
            'departamento_id' => 'Departamento ID',
            'municipio_id' => 'Municipio ID',
            'grupo_vehiculo_id' => 'Grupo Vehiculo ID',
            'consecutivo' => 'Orden N°',
            'total_valor_trabajo' => 'Total Valor Trabajo',
            'total_valor_repuesto' => 'Total Valor Repuesto',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
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
    public function getTipoOrden()
    {
        return $this->hasOne(TiposOrdenes::className(), ['id' => 'tipo_orden_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioConductor()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_conductor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEtiquetaMantenimiento()
    {
        return $this->hasOne(EtiquetasMantenimientos::className(), ['id' => 'etiqueta_mantenimiento_id']);
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
    public function getDepartamento()
    {
        return $this->hasOne(Departamentos::className(), ['id' => 'departamento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipio()
    {
        return $this->hasOne(Municipios::className(), ['id' => 'municipio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoVehiculo()
    {
        return $this->hasOne(GruposVehiculos::className(), ['id' => 'grupo_vehiculo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesTrabajosRepuestos()
    {
        return $this->hasMany(OrdenesTrabajosRepuestos::className(), ['orden_trabajo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesTrabajosTrabajos()
    {
        return $this->hasMany(OrdenesTrabajosTrabajos::className(), ['orden_trabajo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedadesMantenimientos()
    {
        return $this->hasMany(NovedadesMantenimientos::className(), ['orden_trabajo_id' => 'id']);
    }


    /**
     * Asocia los trabajos a la orden de trabajo
     * @param array $repuestos
     */
    public function asociarTrabajo($model, $idMantenimiento = null, $idNovedad = null)
    {
        if ($idMantenimiento != null) {
            $modelo = Mantenimientos::findOne($idMantenimiento);
        } else {
            $modelo = NovedadesMantenimientos::findOne($idNovedad);
        }
        $orden = new OrdenesTrabajosTrabajos();
        $orden->orden_trabajo_id = $model->id;
        $orden->trabajo_id = $modelo->trabajo_id;
        $orden->tipo_mantenimiento_id = $modelo->trabajo->tipo_mantenimiento_id;
        $propiedad = PropiedadesTrabajos::findOne(['trabajo_id' => $modelo->trabajo_id, 'tipo_vehiculo_id' => $modelo->vehiculo->tipo_vehiculo_id]);
        if ($propiedad != null) {
            $orden->costo_mano_obra = $propiedad->costo_mano_obra;
            $orden->cantidad = $propiedad->cantidad_trabajo;
        } else {
            $orden->costo_mano_obra = 0;
            $orden->cantidad = 1;
        }
        if (!$orden->save()) {
            print_r($orden->getErrors());
            die();
        }
    }

    /**
     * Almacena una medicion a la tabla mediciones
     * @param array $q, $idVehiculo
     */
    public function almacenarMedicion($q, $idVehiculo)
    {
        $medicion = new Mediciones();
        $medicion->fecha_medicion = $q['fecha'];
        $medicion->hora_medicion = $q['hora'];
        if ($q['function'] == 'horom') {
            $medicion->valor_medicion = round($q['valor'] / 60);
        } else {
            $medicion->valor_medicion = $q['valor'];
        }
        $medicion->estado_vehiculo = $q['estado'];
        $medicion->tipo_medicion = $q['tipo'];
        $medicion->vehiculo_id = $idVehiculo;
        $medicion->usuario_id = Yii::$app->user->identity->id;
        $medicion->proviene_de = 'Ordenes de Trabajo';
        if (!$medicion->save()) {
            print_r($medicion->getErrors());
            die();
        }
    }

    /* Esta funcion se usara para la validacion entre los 
    *  rangos de las fechas de ingreso, orden y cierre de una orden
    */
    public function validarFechas()
    {
        $fechaIngreso = strtotime($this->fecha_hora_ingreso);
        $fechaOrden = strtotime($this->fecha_hora_orden);
        $fechaCierre = strtotime($this->fecha_hora_cierre);

        $error = null;
        if (!empty($fechaIngreso) && !empty($fechaOrden)) {
            if ($fechaOrden < $fechaIngreso) {
                $error = 'La fecha de la orden no puede ser menor que la fecha de ingreso.';
                $this->addError('fecha_hora_orden', $error);
            }
        }
        if (!empty($fechaCierre) && !empty($fechaOrden)) {
            if ($fechaCierre < $fechaOrden) {
                $error = 'La fecha de cierre no puede ser menor que la fecha de la orden.';
                $this->addError('fecha_hora_cierre', $error);
            }
        }
    }
}
