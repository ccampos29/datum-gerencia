<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "solicitudes".
 *
 * @property int $id
 * @property string $fecha_hora_solicitud Es la fecha y hora de la solicitud
 * @property int $vehiculo_id Dato del vehiculo, si son trabajos
 * @property string $tipo El tipo de de solicitud (repuestos, trabajos)
 * @property string $estado Indica el estado de la solicitud (Abierta, Cerrada, Anulada)
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relacion con Empresa
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property Vehiculos $vehiculo
 * @property SolicitudesRepuestos[] $solicitudesRepuestos
 * @property SolicitudesTrabajos[] $solicitudesTrabajos
 */
class Solicitudes extends MyActiveRecord
{

    public $repuestos;


    public $trabajos;

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
    public static function tableName()
    {
        return 'solicitudes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_hora_solicitud', 'tipo', 'estado'], 'required'],
            [['fecha_hora_solicitud', 'creado_el', 'actualizado_el'], 'safe'],
            [['vehiculo_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['tipo', 'estado'], 'string', 'max' => 255],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['repuestos', 'trabajos'], 'validaciones'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_hora_solicitud' => 'Fecha y hora Solicitud',
            'vehiculo_id' => 'Vehiculo',
            'tipo' => 'Tipo',
            'estado' => 'Estado',
            'consecutivo' => 'Solicitud N°',
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
    public function getCotizaciones()
    {
        return $this->hasMany(Cotizaciones::className(), ['solicitud_id' => 'id']);
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
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['id' => 'empresa_id']);
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
    public function getSolicitudesRepuestos()
    {
        return $this->hasMany(SolicitudesRepuestos::className(), ['solicitud_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudesTrabajos()
    {
        return $this->hasMany(SolicitudesTrabajos::className(), ['solicitud_id' => 'id']);
    }

    /**
     * Asocia los repuestos a la solicitud
     * @param array $repuestos
     */
    public function asociarRepuestos($repuestos)
    {
        $this->eliminarRepuestos($this->id);
        foreach ($repuestos as $repuesto) {
            $solicitudRepuesto = new SolicitudesRepuestos();
            $solicitudRepuesto->solicitud_id = $this->id;
            $solicitudRepuesto->repuesto_id = $repuesto['repuesto_id'];
            $solicitudRepuesto->cantidad = $repuesto['cantidad'];
            $solicitudRepuesto->usuario_reclama_id = $repuesto['usuario_reclama_id'];
            $solicitudRepuesto->observacion = $repuesto['observacion'];
            if (!$solicitudRepuesto->save()) {
                print_r($solicitudRepuesto->getErrors());
                die();
            }
        }
    }


    /**
     * Asocia los trabajos a la solicitud
     * @param array $trabajos
     */
    public function asociarTrabajos($trabajos)
    {
        $this->eliminarTrabajos($this->id);
        foreach ($trabajos as $trabajo) {
            $solicitudTrabajo = new SolicitudesTrabajos();
            $solicitudTrabajo->solicitud_id = $this->id;
            $solicitudTrabajo->trabajo_id = $trabajo['trabajo_id'];
            $solicitudTrabajo->cantidad = $trabajo['cantidad'];
            $solicitudTrabajo->observacion = $trabajo['observacion'];
            if (!$solicitudTrabajo->save()) {
                print_r($solicitudTrabajo->getErrors());
                die();
            }
        }
    }

    /**
     * Elimina los repuestos a la solicitud
     * @param array $id
     */
    public function eliminarRepuestos($id)
    {
        $model = Solicitudes::findOne($id);
        $repuestos = $model->solicitudesRepuestos;

        foreach ($repuestos as $repuesto) {
            $repuesto->delete();
        }
    }

    /**
     * Elimina los trabajos a la solicitud
     * @param array $id
     */
    public function eliminarTrabajos($id)
    {
        $model = Solicitudes::findOne($id);
        $trabajos = $model->solicitudesTrabajos;

        foreach ($trabajos as $trabajo) {
            $trabajo->delete();
        }
    }

    public function antesDelete()
    {
        $model = Solicitudes::findOne($this->id);
        $repuestos = $model->solicitudesRepuestos;

        foreach ($repuestos as $repuesto) {
            $repuesto->delete();
        }

        $trabajos = $model->solicitudesTrabajos;

        foreach ($trabajos as $trabajo) {
            $trabajo->delete();
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->repuestos = $this->solicitudesRepuestos;
        $this->trabajos = $this->solicitudesTrabajos;
    }


    public function validaciones()
    {
        if ($this->tipo == 'Repuestos') {
            foreach ($this->repuestos as $indexRepuesto => $repuesto) {
                if (empty($repuesto['repuesto_id'])) {
                    $error = '"Repuesto" no puede estar vacio.';
                    $this->addError('repuestos[' . $indexRepuesto . '][repuesto_id]', $error);
                }
                if (empty($repuesto['cantidad'])) {
                    $error = '"Cantidad" no puede estar vacio.';
                    $this->addError('repuestos[' . $indexRepuesto . '][cantidad]', $error);
                }
                if (empty($repuesto['usuario_reclama_id'])) {
                    $error = 'Debe seleccionar el usuario que reclama.';
                    $this->addError('repuestos[' . $indexRepuesto . '][usuario_reclama_id]', $error);
                }
                if (empty($repuesto['observacion'])) {
                    $error = 'La observación no puede ir vacia.';
                    $this->addError('repuestos[' . $indexRepuesto . '][observacion]', $error);
                }
            }
        }
        else {
            foreach ($this->trabajos as $indexTrabajos => $trabajo) {
                if (empty($trabajo['trabajo_id'])) {
                    $error = '"Trabajo" no puede estar vacio.';
                    $this->addError('trabajos[' . $indexTrabajos . '][trabajo_id]', $error);
                }
                if (empty($trabajo['cantidad'])) {
                    $error = '"Cantidad" no puede estar vacio.';
                    $this->addError('trabajos[' . $indexTrabajos . '][cantidad]', $error);
                }
                if (empty($trabajo['observacion'])) {
                    $error = 'La observación no puede ir vacia.';
                    $this->addError('trabajos[' . $indexTrabajos . '][observacion]', $error);
                }
            }
        }
    }

    /**
     * Permite saber si un Trabajo se puede eliminar
     * 
     * @return boolean TRUE si se puede eliminar, FALSE de lo contrario
     */
    public function sePuedeEliminar()
    {
        if ($this->cotizaciones) {
            return FALSE;
        }
        if ($this->solicitudesRepuestos) {
            return TRUE;
        }
        if ($this->solicitudesTrabajos) {
            return TRUE;
        }
        return TRUE;
    }

    /**
     * Objetos que están relacionados a través de otros objetos, modelos o tablas
     * que restringen el delete
     * 
     * @return string detalle de los objetos con los cuales está relacionado
     */
    public function objetosRelacionados()
    {
        $detalle = '<ul>';

        if ($this->cotizaciones) {
            $detalle .= '<li>Se debe eliminar la relacion con algunas Cotizaciones</li>';
        }
        $detalle .= '</ul>';
        return $detalle;
    }
}
