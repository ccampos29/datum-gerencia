<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id ID
 * @property string $id_number Número de identificación del usuario
 * @property string $name Nombres
 * @property string $surname Apellidos
 * @property string $username Nombre de usuario
 * @property string $email Correo personal
 * @property int $empresa_id
 * @property int $es_administrador_empresa Inidica si este usuario es administrador de la empresa con la que esta ligado
 * @property int $estado ¿Está activo?
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property int $creado_por Creado por
 * @property string $created_at Creado el
 * @property int $actualizado_por Actualizado por
 * @property string $updated_at Modificado el
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItem[] $itemNames
 * @property AuthMenuItem[] $authMenuItems
 * @property AuthMenuItem[] $authMenuItems0
 * @property CalificacionesChecklist[] $calificacionesChecklists
 * @property CalificacionesChecklist[] $calificacionesChecklists0
 * @property CentrosCostos[] $centrosCostos
 * @property CentrosCostos[] $centrosCostos0
 * @property Checklist[] $checklists
 * @property Checklist[] $checklists0
 * @property Conceptos[] $conceptos
 * @property Conceptos[] $conceptos0
 * @property CriteriosEvaluaciones[] $criteriosEvaluaciones
 * @property CriteriosEvaluaciones[] $criteriosEvaluaciones0
 * @property Departamentos[] $departamentos
 * @property Departamentos[] $departamentos0
 * @property DocumentosProveedores[] $documentosProveedores
 * @property DocumentosProveedores[] $documentosProveedores0
 * @property Empresas[] $empresas
 * @property Empresas[] $empresas0
 * @property EstadosChecklist[] $estadosChecklists
 * @property EstadosChecklist[] $estadosChecklists0
 * @property EtiquetasMantenimientos[] $etiquetasMantenimientos
 * @property EtiquetasMantenimientos[] $etiquetasMantenimientos0
 * @property GruposInsumos[] $gruposInsumos
 * @property GruposInsumos[] $gruposInsumos0
 * @property GruposNovedades[] $gruposNovedades
 * @property GruposNovedades[] $gruposNovedades0
 * @property GruposVehiculos[] $gruposVehiculos
 * @property GruposVehiculos[] $gruposVehiculos0
 * @property ImagenesEmpresas[] $imagenesEmpresas
 * @property ImagenesEmpresas[] $imagenesEmpresas0
 * @property LineasMarcas[] $lineasMarcas
 * @property LineasMarcas[] $lineasMarcas0
 * @property LineasMotores[] $lineasMotores
 * @property LineasMotores[] $lineasMotores0
 * @property Mantenimientos[] $mantenimientos
 * @property Mantenimientos[] $mantenimientos0
 * @property MarcasMotores[] $marcasMotores
 * @property MarcasMotores[] $marcasMotores0
 * @property MarcasVehiculos[] $marcasVehiculos
 * @property MarcasVehiculos[] $marcasVehiculos0
 * @property Mediciones[] $mediciones
 * @property Mediciones[] $mediciones0
 * @property Motores[] $motores
 * @property Motores[] $motores0
 * @property Municipios[] $municipios
 * @property Municipios[] $municipios0
 * @property Novedades[] $novedades
 * @property Novedades[] $novedades0
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_number', 'name', 'surname', 'username', 'estado', 'auth_key', 'password_hash', 'verification_token', 'created_at', 'updated_at'], 'required'],
            [['empresa_id', 'es_administrador_empresa', 'estado', 'creado_por', 'actualizado_por'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_number'], 'string', 'max' => 30],
            [['name', 'surname', 'email'], 'string', 'max' => 100],
            [['username'], 'string', 'max' => 20],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'verification_token'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['id_number'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_number' => 'Id Number',
            'name' => 'Name',
            'surname' => 'Surname',
            'username' => 'Username',
            'email' => 'Email',
            'empresa_id' => 'Empresa ID',
            'es_administrador_empresa' => 'Es Administrador Empresa',
            'estado' => 'Estado',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'verification_token' => 'Verification Token',
            'creado_por' => 'Creado Por',
            'created_at' => 'Created At',
            'actualizado_por' => 'Actualizado Por',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemNames()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'item_name'])->viaTable('auth_assignment', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthMenuItems()
    {
        return $this->hasMany(AuthMenuItem::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthMenuItems0()
    {
        return $this->hasMany(AuthMenuItem::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacionesChecklists()
    {
        return $this->hasMany(CalificacionesChecklist::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacionesChecklists0()
    {
        return $this->hasMany(CalificacionesChecklist::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentrosCostos()
    {
        return $this->hasMany(CentrosCostos::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentrosCostos0()
    {
        return $this->hasMany(CentrosCostos::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklists()
    {
        return $this->hasMany(Checklist::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklists0()
    {
        return $this->hasMany(Checklist::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConceptos()
    {
        return $this->hasMany(Conceptos::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConceptos0()
    {
        return $this->hasMany(Conceptos::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriosEvaluaciones()
    {
        return $this->hasMany(CriteriosEvaluaciones::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriosEvaluaciones0()
    {
        return $this->hasMany(CriteriosEvaluaciones::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamentos()
    {
        return $this->hasMany(Departamentos::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamentos0()
    {
        return $this->hasMany(Departamentos::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentosProveedores()
    {
        return $this->hasMany(DocumentosProveedores::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentosProveedores0()
    {
        return $this->hasMany(DocumentosProveedores::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Empresas::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas0()
    {
        return $this->hasMany(Empresas::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadosChecklists()
    {
        return $this->hasMany(EstadosChecklist::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadosChecklists0()
    {
        return $this->hasMany(EstadosChecklist::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEtiquetasMantenimientos()
    {
        return $this->hasMany(EtiquetasMantenimientos::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEtiquetasMantenimientos0()
    {
        return $this->hasMany(EtiquetasMantenimientos::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposInsumos()
    {
        return $this->hasMany(GruposInsumos::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposInsumos0()
    {
        return $this->hasMany(GruposInsumos::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposNovedades()
    {
        return $this->hasMany(GruposNovedades::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposNovedades0()
    {
        return $this->hasMany(GruposNovedades::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposVehiculos()
    {
        return $this->hasMany(GruposVehiculos::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposVehiculos0()
    {
        return $this->hasMany(GruposVehiculos::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenesEmpresas()
    {
        return $this->hasMany(ImagenesEmpresas::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenesEmpresas0()
    {
        return $this->hasMany(ImagenesEmpresas::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineasMarcas()
    {
        return $this->hasMany(LineasMarcas::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineasMarcas0()
    {
        return $this->hasMany(LineasMarcas::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineasMotores()
    {
        return $this->hasMany(LineasMotores::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineasMotores0()
    {
        return $this->hasMany(LineasMotores::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMantenimientos()
    {
        return $this->hasMany(Mantenimientos::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMantenimientos0()
    {
        return $this->hasMany(Mantenimientos::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarcasMotores()
    {
        return $this->hasMany(MarcasMotores::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarcasMotores0()
    {
        return $this->hasMany(MarcasMotores::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarcasVehiculos()
    {
        return $this->hasMany(MarcasVehiculos::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarcasVehiculos0()
    {
        return $this->hasMany(MarcasVehiculos::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediciones()
    {
        return $this->hasMany(Mediciones::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediciones0()
    {
        return $this->hasMany(Mediciones::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotores()
    {
        return $this->hasMany(Motores::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotores0()
    {
        return $this->hasMany(Motores::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipios()
    {
        return $this->hasMany(Municipios::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipios0()
    {
        return $this->hasMany(Municipios::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedades()
    {
        return $this->hasMany(Novedades::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedades0()
    {
        return $this->hasMany(Novedades::className(), ['actualizado_por' => 'id']);
    }

}
