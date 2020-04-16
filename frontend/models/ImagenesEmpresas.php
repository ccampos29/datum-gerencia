<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "imagenes_empresas".
 *
 * @property int $id
 * @property int $empresa_id Empresa con la que esta asociado este archivo (logo)
 * @property string $nombre_archivo_original Nombre original del archivo cargado
 * @property string $nombre_archivo Nombre con el que se almacena el archivo en el servidor
 * @property string $ruta_archivo Ruta donde esta guardada la imagen en el servidor
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Empresas $empresa
 */
class ImagenesEmpresas extends \common\models\MyActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'imagenes_empresas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['empresa_id', 'nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'required'],
            [['empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'string', 'max' => 355],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'empresa_id' => 'Empresa ID',
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
    public function getCreadoPor() {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActualizadoPor() {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa() {
        return $this->hasOne(Empresas::className(), ['id' => 'empresa_id']);
    }

}
