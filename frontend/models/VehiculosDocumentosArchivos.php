<?php

namespace frontend\models;
use common\models\User;
use Yii;

/**
 * This is the model class for table "vehiculos_documentos_archivos".
 *
 * @property int $id
 * @property int $vehiculo_id Vehiculo al que se asocia el documento
 * @property int $tipo_documento_id Tipo de documento
 * @property string $nombre_archivo_original Nombre original del documento cargado
 * @property string $nombre_archivo Nombre asignado original del documento cargado
 * @property string $ruta_archivo Ruta de la ubicación del documento
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 * @property int $es_actual Indica si el documento es actual o no
 *
 * @property Vehiculos $vehiculo
 * @property TiposOtrosDocumentos $tipoDocumento
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Empresas $empresa
 */
class VehiculosDocumentosArchivos extends \common\models\MyActiveRecord
{
    public $documento;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehiculos_documentos_archivos';
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
            [['vehiculo_id', 'tipo_documento_id', 'nombre_archivo_original', 'nombre_archivo', 'ruta_archivo', 'es_actual'], 'required'],
            [['vehiculo_id', 'tipo_documento_id', 'creado_por', 'actualizado_por', 'empresa_id', 'es_actual'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'string', 'max' => 355],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['tipo_documento_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposOtrosDocumentos::className(), 'targetAttribute' => ['tipo_documento_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
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
            'vehiculo_id' => 'Vehiculo',
            'tipo_documento_id' => 'Tipo del documento',
            'nombre_archivo_original' => 'Nombre Archivo Original',
            'nombre_archivo' => 'Nombre Archivo',
            'ruta_archivo' => 'Ruta Archivo',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
            'es_actual' => 'Es Actual',
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
    public function getTipoDocumento()
    {
        return $this->hasOne(TiposOtrosDocumentos::className(), ['id' => 'tipo_documento_id']);
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
}
