<?php

namespace frontend\models;

use common\models\User;

use common\models\MyActiveRecord;
use Yii;

/**
 * This is the model class for table "imagenes_checklist".
 *
 * @property int $id
 * @property int $checklist_id Checklist con la que esta asociado este archivo (foto)
 * @property string $nombre_archivo_original Nombre original del archivo cargado
 * @property string $nombre_archivo Nombre con el que se almacena el archivo en el servidor
 * @property string $ruta_archivo Ruta donde esta guardada la imagen en el servidor
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 *
 * @property Checklist $checklist
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Empresas $empresa
 */
class ImagenesChecklist extends MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagenes_checklist';
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
            [['checklist_id', 'nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'required'],
            [['checklist_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'string', 'max' => 355],
            [['checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Checklist::className(), 'targetAttribute' => ['checklist_id' => 'id']],
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
            'checklist_id' => 'Checklist ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklist()
    {
        return $this->hasOne(Checklist::className(), ['id' => 'checklist_id']);
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
