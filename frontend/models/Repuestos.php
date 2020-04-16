<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use common\models\User;

use Yii;

/**
 * This is the model class for table "repuestos".
 *
 * @property int $id
 * @property string $nombre Es el nombre del repuesto
 * @property string $fabricante Es el nombre del fabriacante del repuesto
 * @property double $precio Es el valor del repuesto
 * @property string $observacion Es una pequeña descripcion del repuesto
 * @property string $codigo Es el codigo especifico de cada empresa para cada repuesto
 * @property int $estado Determina si el repuesto esta activo o inactivo
 * @property int $inventariable Determina si el repuesto se puede inventariar
 * @property int $unidad_medida_id Es la unidad en la que se mide el repuesto (galones, metros, centimetros, unidades)
 * @property int $grupo_repuesto_id Es el grupo donde esta asignado el repuesto
 * @property int $sistema_id El sistema asociado al repuesto
 * @property int $subsistema_id El subsistema asociado al repuesto
 * @property int $cuenta_contable_id Es la cuenta contable como se pagará el repuesto
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Sistemas $sistema
 * @property Subsistemas $subsistema
 * @property RutinasRepuestos[] $rutinasRepuestos
 */
class Repuestos extends MyActiveRecord
{

    public $proveedores;
    public $inventarios;

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
        return 'repuestos';
    }

     /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'precio', 'unidad_medida_id', 'inventariable'], 'required'],
            [['precio'], 'number'],
            [['estado', 'inventariable', 'unidad_medida_id', 'grupo_repuesto_id', 'sistema_id', 'subsistema_id', 'cuenta_contable_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre', 'fabricante'], 'string', 'max' => 255],
            [['observacion'], 'string', 'max' => 355],
            [['codigo'], 'string', 'max' => 20],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['sistema_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sistemas::className(), 'targetAttribute' => ['sistema_id' => 'id']],
            [['subsistema_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subsistemas::className(), 'targetAttribute' => ['subsistema_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['unidad_medida_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnidadesMedidas::className(), 'targetAttribute' => ['unidad_medida_id' => 'id']],
            [['grupo_repuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => GruposInsumos::className(), 'targetAttribute' => ['grupo_repuesto_id' => 'id']],
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
            'fabricante' => 'Fabricante',
            'precio' => 'Precio',
            'observacion' => 'Observacion',
            'codigo' => 'Codigo',
            'estado' => 'Estado',
            'inventariable' => 'Inventariable',
            'unidad_medida_id' => 'Unidad Medida',
            'grupo_repuesto_id' => 'Grupo Repuesto',
            'sistema_id' => 'Sistema',
            'subsistema_id' => 'Subsistema',
            'cuenta_contable_id' => 'Cuenta Contable',
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
    public function getComprasRepuestos()
    {
        return $this->hasMany(ComprasRepuestos::className(), ['repuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacionesRepuestos()
    {
        return $this->hasMany(CotizacionesRepuestos::className(), ['repuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventariosAjustes()
    {
        return $this->hasMany(InventariosAjustes::className(), ['repuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventariosRepuestos()
    {
        return $this->hasMany(InventariosRepuestos::className(), ['repuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesComprasRepuestos()
    {
        return $this->hasMany(OrdenesComprasRepuestos::className(), ['repuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesTrabajosRepuestos()
    {
        return $this->hasMany(OrdenesTrabajosRepuestos::className(), ['repuesto_id' => 'id']);
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
    public function getUnidadMedida()
    {
        return $this->hasOne(UnidadesMedidas::className(), ['id' => 'unidad_medida_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoRepuesto()
    {
        return $this->hasOne(GruposInsumos::className(), ['id' => 'grupo_repuesto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuentaContable()
    {
        return $this->hasOne(CuentasContables::className(), ['id' => 'cuenta_contable_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepuestosInventariables()
    {
        return $this->hasMany(RepuestosInventariables::className(), ['repuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepuestosProveedores()
    {
        return $this->hasMany(RepuestosProveedores::className(), ['repuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinasRepuestos()
    {
        return $this->hasMany(RutinasRepuestos::className(), ['repuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudesRepuestos()
    {
        return $this->hasMany(SolicitudesRepuestos::className(), ['repuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTraslados()
    {
        return $this->hasMany(Traslados::className(), ['repuesto_id' => 'id']);
    }


    public function antesDelete()
    {
        $model = Repuestos::findOne($this->id);
        $proveedores = $model->repuestosProveedores;

        foreach ($proveedores as $proveedor) {
            $proveedor->delete();
        }

        $inventarios = $model->repuestosInventariables;

        foreach ($inventarios as $inventario) {
            $inventario->delete();
        }
    }


    /**
     * Permite saber si un Trabajo se puede eliminar
     * 
     * @return boolean TRUE si se puede eliminar, FALSE de lo contrario
     */
    public function sePuedeEliminar()
    {
        if ($this->comprasRepuestos) {
            return FALSE;
        }
        if ($this->cotizacionesRepuestos) {
            return FALSE;
        }
        if ($this->inventariosAjustes) {
            return FALSE;
        }
        if ($this->inventariosRepuestos) {
            return FALSE;
        }
        if ($this->ordenesComprasRepuestos) {
            return FALSE;
        }
        if ($this->ordenesTrabajosRepuestos) {
            return FALSE;
        }
        if ($this->repuestosProveedores) {
            return TRUE;
        }
        if ($this->repuestosInventariables) {
            return TRUE;
        }
        if ($this->solicitudesRepuestos) {
            return FALSE;
        }
        if ($this->rutinasRepuestos) {
            return FALSE;
        }
        if ($this->traslados) {
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

        if ($this->comprasRepuestos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunas Compras</li>';
        }
        if ($this->cotizacionesRepuestos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunas Cotizaciones</li>';
        }
        if ($this->inventariosAjustes) {
            $detalle .= '<li>Se debe eliminar la relacion con algunos Ajustes de Inventario</li>';
        }
        if ($this->inventariosRepuestos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunos Inventarios Fisicos</li>';
        }
        if ($this->ordenesComprasRepuestos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunas Ordenes de Compra</li>';
        }
        if ($this->ordenesTrabajosRepuestos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunas Ordenes de Trabajos</li>';
        }
        if ($this->solicitudesRepuestos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunas Solicitudes</li>';
        }
        if ($this->rutinasRepuestos) {
            $detalle .= '<li>Se debe eliminar la relacion con algunas Rutinas</li>';
        }
        if ($this->traslados) {
            $detalle .= '<li>Se debe eliminar la relacion con algunos Traslados</li>';
        }
        $detalle .= '</ul>';
        return $detalle;
    }
}
