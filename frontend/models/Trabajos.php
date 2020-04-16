<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "trabajos".
 *
 * @property int $id
 * @property string $nombre Es el nombre de un trabajo especifico
 * @property string $observacion Es una pequeña descripcion del trabajo
 * @property string $codigo Es el codigo especifico de cada empresa para cada trabajo
 * @property int $estado Determina si el trabajo esta activo o inactivo
 * @property int $tipo_mantenimiento_id A que tipo de mantenimiento pertenece el trabajo
 * @property int $sistema_id El sistema asociado al trabajo
 * @property int $subsistema_id El subsistema asociado al trabajo
 * @property int $cuenta_contable_id Es la cuenta contable como se pagará el trabajo
 * @property int $periodico Determina si el trabajo es tiene una periodicidad
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property Mantenimientos[] $mantenimientos
 * @property RutinasTrabajos[] $rutinasTrabajos
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property TiposMantenimientos $tipoMantenimiento
 * @property Sistemas $sistema
 * @property Subsistemas $subsistema
 */
class Trabajos extends MyActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trabajos';
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
            [['nombre', 'tipo_mantenimiento_id', 'sistema_id', 'subsistema_id', 'cuenta_contable_id', 'estado'], 'required'],
            [['estado', 'tipo_mantenimiento_id', 'sistema_id', 'subsistema_id', 'cuenta_contable_id', 'periodico', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['tipo_mantenimiento_id', 'creado_el', 'actualizado_el', 'periodico'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
            [['observacion'], 'string', 'max' => 355],
            [['codigo'], 'string', 'max' => 20],
            [['nombre'], 'unique'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['tipo_mantenimiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposMantenimientos::className(), 'targetAttribute' => ['tipo_mantenimiento_id' => 'id']],
            [['sistema_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sistemas::className(), 'targetAttribute' => ['sistema_id' => 'id']],
            [['subsistema_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subsistemas::className(), 'targetAttribute' => ['subsistema_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['cuenta_contable_id'], 'exist', 'skipOnError' => true, 'targetClass' => CuentasContables::className(), 'targetAttribute' => ['cuenta_contable_id' => 'id']],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'observacion' => 'Observacion',
            'codigo' => 'Codigo',
            'estado' => 'Estado',
            'tipo_mantenimiento_id' => 'Tipo Mantenimiento',
            'sistema_id' => 'Sistema',
            'subsistema_id' => 'Subsistema',
            'cuenta_contable_id' => 'Cuenta Contable',
            'periodico' => 'Periodico',
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
    public function getCotizacionesTrabajos()
    {
        return $this->hasMany(CotizacionesTrabajos::className(), ['trabajo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMantenimientos()
    {
        return $this->hasMany(Mantenimientos::className(), ['trabajo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedadesMantenimientos()
    {
        return $this->hasMany(NovedadesMantenimientos::className(), ['trabajo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesTrabajosTrabajos()
    {
        return $this->hasMany(OrdenesTrabajosTrabajos::className(), ['trabajo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodicidadesTrabajos()
    {
        return $this->hasMany(PeriodicidadesTrabajos::className(), ['trabajo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropiedadesTrabajos()
    {
        return $this->hasMany(PropiedadesTrabajos::className(), ['trabajo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinasTrabajos()
    {
        return $this->hasMany(RutinasTrabajos::className(), ['trabajo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudesTrabajos()
    {
        return $this->hasMany(SolicitudesTrabajos::className(), ['trabajo_id' => 'id']);
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
    public function getTipoMantenimiento()
    {
        return $this->hasOne(TiposMantenimientos::className(), ['id' => 'tipo_mantenimiento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSistema()
    {
        return $this->hasOne(Sistemas::className(), ['id' => 'sistema_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubsistema()
    {
        return $this->hasOne(Subsistemas::className(), ['id' => 'subsistema_id']);
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
    public function getCuentaContable()
    {
        return $this->hasOne(CuentasContables::className(), ['id' => 'cuenta_contable_id']);
    }


    public function antesDelete()
    {
        $model = Trabajos::findOne($this->id);
        $propiedades = $model->propiedadesTrabajos;
        $periodicidades = $model->periodicidadesTrabajos;

        foreach ($propiedades as $propiedad) {
            $propiedad->delete();
        }

        foreach ($periodicidades as $periodicidad) {
            $periodicidad->delete();
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->subsistema_id = $this->subsistema;
    }

    public function validarPropiedades()
    {
        foreach ($this->propiedades as $indexPropiedad => $propiedad) {
            if (empty($propiedad['tipo_vehiculo_id'])) {
                $error = '"Tipo Vehiculo" no puede estar vacio.';
                $this->addError('propiedades[' . $indexPropiedad . '][tipo_vehiculo_id]', $error);
            }
            if (empty($propiedad['duracion'])) {
                $error = '"Duracion" no puede estar vacio.';
                $this->addError('propiedades[' . $indexPropiedad . '][duracion]', $error);
            }
            if (empty($propiedad['costo_mano_obra'])) {
                $error = '"Costo Mano de Obra" no puede estar vacio.';
                $this->addError('propiedades[' . $indexPropiedad . '][costo_mano_obra]', $error);
            }
            if (empty($propiedad['cantidad_trabajo'])) {
                $error = '"Cantidad" no puede estar vacio.';
                $this->addError('propiedades[' . $indexPropiedad . '][cantidad_trabajo]', $error);
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
        if ($this->propiedadesTrabajos) {
            return TRUE;
        }
        if ($this->periodicidadesTrabajos) {
            return TRUE;
        }
        if ($this->mantenimientos) {
            return FALSE;
        }
        if ($this->cotizacionesTrabajos) {
            return FALSE;
        }
        if ($this->novedadesMantenimientos) {
            return FALSE;
        }
        if ($this->ordenesTrabajosTrabajos) {
            return FALSE;
        }
        if ($this->rutinasTrabajos) {
            return FALSE;
        }
        if ($this->solicitudesTrabajos) {
            return FALSE;
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

        if ($this->solicitudesTrabajos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunas solicitudes</li>';
        }

        if ($this->mantenimientos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunos Mantenimientos</li>';
        }
        if ($this->cotizacionesTrabajos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunas Cotizaciones</li>';
        }
        if ($this->novedadesMantenimientos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunas Novedades de Mantenimiento</li>';
        }
        if ($this->ordenesTrabajosTrabajos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunas Ordenes de Trabajos</li>';
        }
        if ($this->rutinasTrabajos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunas Rutinas</li>';
        }
        $detalle .= '</ul>';
        return $detalle;
    }
}
