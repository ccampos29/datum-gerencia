<?php

namespace frontend\models;
use common\models\User;
use Yii;

/**
 * This is the model class for table "imagenes_combustibles".
 *
 * @property int $id
 * @property int $combustible_id combustibles con la que esta asociado este archivo (foto)
 * @property string $nombre_archivo_original Nombre original del archivo cargado
 * @property string $nombre_archivo Nombre con el que se almacena el archivo en el servidor
 * @property string $ruta_archivo Ruta donde esta guardada la imagen en el servidor
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 */
class ImagenesCombustibles extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagenes_combustibles';
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
            [['combustible_id', 'nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'required'],
            [['id', 'combustible_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'string', 'max' => 355],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'combustible_id' => 'Combustible ID',
            'nombre_archivo_original' => 'Nombre Archivo Original',
            'nombre_archivo' => 'Nombre Archivo',
            'ruta_archivo' => 'Ruta Archivo',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
        ];
    }
}
