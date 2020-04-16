<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "documentos_proveedores".
 *
 * @property string $id
 * @property string $tipo_documento_id Tipo de documento
 * @property double $valor_documento Precio del documento cargado
 * @property string $fecha_expedicion Fecha en que se expide el documento
 * @property string $fecha_inicio_cubrimiento Fecha desde la que cubre el documento
 * @property string $fecha_fin_cubrimiento Fecha fin, hasta que cubre el documento
 * @property int $es_actual Indica si el documento es actual o no
 * @property string $observacion Observación del documento cargado
 * @property string $proveedor_id Proveedor al que pertenece este documento
 * @property string $nombre_archivo_original Nombre original del documento cargado
 * @property string $nombre_archivo Nombre asignado original del documento cargado
 * @property string $ruta_archivo Ruta de la ubicación del documento
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property TiposDocumentos $tipoDocumento
 * @property Proveedor $proveedor
 */
class DocumentosProveedores extends \common\models\MyActiveRecord
{
    public $documento;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documentos_proveedores';
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
            [['tipo_documento_id', 'valor_documento', 'fecha_expedicion', 'fecha_inicio_cubrimiento', 'fecha_fin_cubrimiento', 'es_actual', 'proveedor_id', 'nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'required'],
            [['tipo_documento_id', 'es_actual', 'proveedor_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['valor_documento'], 'number'],
            [['fecha_expedicion', 'fecha_inicio_cubrimiento', 'fecha_fin_cubrimiento', 'creado_el', 'actualizado_el'], 'safe'],
            [['observacion'], 'string'],
            [['nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'string', 'max' => 355],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['tipo_documento_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposDocumentos::className(), 'targetAttribute' => ['tipo_documento_id' => 'id']],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            ['fecha_inicio_cubrimiento', 'compare', 'compareAttribute'=>'fecha_fin_cubrimiento', 'operator'=>'<'],
            ['fecha_fin_cubrimiento', 'compare', 'compareAttribute'=>'fecha_inicio_cubrimiento', 'operator'=>'>'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_documento_id' => 'Tipo Documento',
            'valor_documento' => 'Valor Documento',
            'fecha_expedicion' => 'Fecha Expedicion',
            'fecha_inicio_cubrimiento' => 'Fecha Inicio Cubrimiento',
            'fecha_fin_cubrimiento' => 'Fecha Fin Cubrimiento',
            'es_actual' => 'Es Actual',
            'observacion' => 'Observacion',
            'proveedor_id' => 'Proveedor',
            'nombre_archivo_original' => 'Nombre Archivo Original',
            'nombre_archivo' => 'Nombre Archivo',
            'ruta_archivo' => 'Ruta Archivo',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
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
    public function getTipoDocumento()
    {
        return $this->hasOne(TiposDocumentos::className(), ['id' => 'tipo_documento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedor()
    {
        return $this->hasOne(Proveedores::className(), ['id' => 'proveedor_id']);
    }

}
