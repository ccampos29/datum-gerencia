<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use common\models\User;
use Yii;

/**
 * This is the model class for table "usuarios_documentos_usuarios".
 *
 * @property int $id
 * @property int $usuario_documento_id Relacion con usuarios_documentos
 * @property int $proveedor_id Relacion con proveedores
 * @property int $codigo Codigo del documento
 * @property int $valor_documento Valor del documento
 * @property string $fecha_expedicion Fecha de expedicion del documento
 * @property int $actual Codigo del documento
 * @property string|null $observacion Observacion del registro
 * @property string $fecha_vigencia Fecha inicial de la vigencia del documento
 * @property string $fecha_expiracion Fecha de expiracion del documento
 * @property int $centro_costo_id Relacion con centros_costos
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relacion con empresa
 * @property int $usuario_id Relacion con usuarios
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property Proveedores $proveedor
 * @property UsuariosDocumentos $usuarioDocumento
 * @property User $usuario
 */
class UsuariosDocumentosUsuarios extends MyActiveRecord

{
    public $documento;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios_documentos_usuarios';
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
        return parent::find()->andFilterWhere(['empresa_id'=>@Yii::$app->user->identity->empresa_id]);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_documento_id', 'proveedor_id', 'valor_documento', 'fecha_expedicion', 'actual', 'fecha_expiracion', 'centro_costo_id', 'usuario_id'], 'required'],
            [['usuario_documento_id', 'proveedor_id', 'codigo', 'valor_documento', 'actual', 'centro_costo_id', 'creado_por', 'actualizado_por', 'empresa_id', 'usuario_id'], 'integer'],
            [['fecha_expedicion', 'fecha_expiracion', 'creado_el', 'actualizado_el'], 'safe'],
            [['observacion'], 'string'],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['usuario_documento_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosDocumentos::className(), 'targetAttribute' => ['usuario_documento_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_documento_id' => 'Usuario Documento',
            'proveedor_id' => 'Proveedor',
            'codigo' => 'Codigo',
            'valor_documento' => 'Valor Documento',
            'fecha_expedicion' => 'Fecha Expedicion',
            'actual' => 'Actual',
            'observacion' => 'Observacion',
            'fecha_expiracion' => 'Fecha Expiracion',
            'centro_costo_id' => 'Centro Costo ID',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
            'usuario_id' => 'Usuario',
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
    public function getUsuarioDocumento()
    {
        return $this->hasOne(UsuariosDocumentos::className(), ['id' => 'usuario_documento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentroCosto()
    {
        return $this->hasOne(CentrosCostos::className(), ['id' => 'centro_costo_id']);
    }
}
