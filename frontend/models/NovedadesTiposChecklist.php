<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "novedades_tipos_checklist".
 *
 * @property int $id
 * @property int $novedad_id Nombre de la novedad
 * @property int $tipo_checklist_id Relación con el grupo de novedades
 * @property int $empresa_id Relación con empresa
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property TiposChecklist $id0
 * @property User $creadoPor
 * @property Novedades $novedad
 */
class NovedadesTiposChecklist extends \common\models\MyActiveRecord
{
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
    public static function tableName()
    {
        return 'novedades_tipos_checklist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'novedad_id', 'tipo_checklist_id'], 'integer'],
            [['novedad_id', 'tipo_checklist_id'], 'required'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Novedades::className(), 'targetAttribute' => ['novedad_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'novedad_id' => 'Novedad ID',
            'tipo_checklist_id' => 'Tipo Checklist ID',
            'empresa_id' => 'Empresa ID',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
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
    public function getTipoChecklist()
    {
        return $this->hasOne(TiposChecklist::className(), ['id' => 'tipo_checklist_id']);
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
    public function getNovedad()
    {
        return $this->hasOne(Novedades::className(), ['id' => 'novedad_id']);
    }
}
