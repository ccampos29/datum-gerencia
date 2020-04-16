<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "proveedor".
 *
 * @property string $id
 * @property string $tipo_proveedor_id Relación con el tipo de proveedor
 * @property string $nombre Nombre del proveedor
 * @property string $identificacion Identificación del proveedor la intención e sque siempre sea NIT
 * @property string $digito_verificacion Digito de verificación que complementa el NIT
 * @property string $telefono_fijo_celular Teléfono fijo o celular del proveedor
 * @property string $email Email del proveedor
 * @property string $direccion Dirección del proveedor
 * @property string $nombre_contacto Nombre del contacto del proveedor
 * @property string $pais_id Pais en el que se encuentra este proveedor
 * @property string $departamento_id Departamento en el que se encuentra este proveedor
 * @property string $municipio_id Municipio en el que se encuentra este proveedor
 * @property string $regimen Regimen al que pertenece este proveedor
 * @property string $tipo_procedencia Procedencía del proveedor
 * @property int $activo Inidca si un proveedor esta activo o no
 * @property string $empresa_id
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 *
 * @property Combustibles[] $combustibles
 * @property DocumentosProveedores[] $documentosProveedores
 * @property Mediciones[] $mediciones
 * @property OrdenesTrabajos[] $ordenesTrabajos
 * @property OtrosGastos[] $otrosGastos
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Pais $pais
 * @property Departamentos $departamento
 * @property Municipios $municipio
 * @property TiposProveedores $tipoProveedor
 * @property Empresas $empresa
 * @property RepuestosProveedores[] $repuestosProveedores
 * @property VehiculosOtrosDocumentos[] $vehiculosOtrosDocumentos
 * @property VehiculosSeguros[] $vehiculosSeguros
 */
class Proveedores extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proveedores';
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
            [['tipo_proveedor_id', 'nombre', 'identificacion', 'digito_verificacion', 'telefono_fijo_celular', 'email', 'direccion', 'nombre_contacto', 'pais_id', 'departamento_id', 'municipio_id', 'regimen', 'tipo_procedencia', 'activo'], 'required'],
            [['tipo_proveedor_id', 'pais_id', 'departamento_id', 'municipio_id', 'activo', 'empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['regimen', 'tipo_procedencia'], 'string'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre', 'email', 'nombre_contacto'], 'string', 'max' => 355],
            [['identificacion'], 'string', 'max' => 20],
            [['email'],'email'],
            [['digito_verificacion'], 'string', 'max' => 3],
            [['telefono_fijo_celular'], 'string', 'max' => 12],
            [['direccion'], 'string', 'max' => 500],
            ['identificacion', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Por favor sólo ingrese números.'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['pais_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['pais_id' => 'id']],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamentos::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['municipio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Municipios::className(), 'targetAttribute' => ['municipio_id' => 'id']],
            [['tipo_proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposProveedores::className(), 'targetAttribute' => ['tipo_proveedor_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_proveedor_id' => 'Tipo Proveedor',
            'nombre' => 'Nombre',
            'identificacion' => 'Identificacion',
            'digito_verificacion' => 'Digito Verificacion',
            'telefono_fijo_celular' => 'Telefono Fijo Celular',
            'email' => 'Email',
            'direccion' => 'Direccion',
            'nombre_contacto' => 'Nombre Contacto',
            'pais_id' => 'Pais',
            'departamento_id' => 'Departamento',
            'municipio_id' => 'Municipio',
            'regimen' => 'Regimen',
            'tipo_procedencia' => 'Tipo Procedencia',
            'activo' => 'Activo',
            'empresa_id' => 'Empresa',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCombustibles()
    {
        return $this->hasMany(Combustibles::className(), ['proveedor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentosProveedores()
    {
        return $this->hasMany(DocumentosProveedores::className(), ['proveedor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediciones()
    {
        return $this->hasMany(Mediciones::className(), ['proveedor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesTrabajos()
    {
        return $this->hasMany(OrdenesTrabajos::className(), ['proveedor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOtrosGastos()
    {
        return $this->hasMany(OtrosGastos::className(), ['proveedor_id' => 'id']);
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
    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'pais_id']);
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
    public function getTipoProveedor()
    {
        return $this->hasOne(TiposProveedores::className(), ['id' => 'tipo_proveedor_id']);
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
    public function getRepuestosProveedores()
    {
        return $this->hasMany(RepuestosProveedores::className(), ['proveedor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosOtrosDocumentos()
    {
        return $this->hasMany(VehiculosOtrosDocumentos::className(), ['proveedores_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosSeguros()
    {
        return $this->hasMany(VehiculosSeguros::className(), ['proveedor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesCompras()
    {
        return $this->hasMany(OrdenesCompras::className(), ['proveedor_id' => 'id']);
    }
}
