<?php

namespace frontend\models;
use common\models\User;
use Yii;

/**
 * This is the model class for table "vehiculos_seguros_archivos".
 *
 * @property int $id
 * @property int $vehiculo_id Vehiculo al que se asocia el seguro
 * @property int $tipo_seguro_id Tipo de seguro
 * @property string $nombre_archivo_original Nombre original del seguro cargado
 * @property string $nombre_archivo Nombre asignado original del seguro cargado
 * @property string $ruta_archivo Ruta de la ubicación del seguro
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 * @property int $es_actual Indica si el seguro es actual o no
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property TiposSeguros $tipoSeguro
 * @property Vehiculos $vehiculo
 */
class VehiculosSegurosArchivos extends \common\models\MyActiveRecord
{
    public $seguro;
    public $foto;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehiculos_seguros_archivos';
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
            [['vehiculo_id', 'tipo_seguro_id', 'nombre_archivo_original', 'nombre_archivo', 'ruta_archivo', 'es_actual'], 'required'],
            [['vehiculo_id', 'tipo_seguro_id', 'creado_por', 'actualizado_por', 'empresa_id', 'es_actual'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'string', 'max' => 355],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['tipo_seguro_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposSeguros::className(), 'targetAttribute' => ['tipo_seguro_id' => 'id']],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
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
            'tipo_seguro_id' => 'Tipo del seguro',
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
    public function getTipoSeguro()
    {
        return $this->hasOne(TiposSeguros::className(), ['id' => 'tipo_seguro_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculos::className(), ['id' => 'vehiculo_id']);
    }

}
