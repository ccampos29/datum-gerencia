<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;
use common\models\User;

/**
 * This is the model class for table "general_inventario".
 *
 * @property int $id
 * @property int $ubicacion_insumo_id
 * @property int $descarga_respuestos
 * @property int $empresa_id Relación con empresa
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Empresas $empresa
 * @property UbicacionesInsumosUsuarios $ubicacionInsumo
 */
class GeneralInventario extends MyActiveRecord
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
        return 'general_inventario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ubicacion_insumo_id', 'descarga_respuestos'], 'required'],
            [['ubicacion_insumo_id', 'descarga_respuestos'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['ubicacion_insumo_id'], 'exist', 'skipOnError' => true, 'targetClass' => UbicacionesInsumos::className(), 'targetAttribute' => ['ubicacion_insumo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ubicacion_insumo_id' => 'Proveedor interno para descargue de O.T	',
            'descarga_respuestos' => 'Descargar Repuestos a OT automáticamente al hacer la Compra',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacionInsumo()
    {
        return $this->hasOne(UbicacionesInsumos::className(), ['id' => 'ubicacion_insumo_id']);
    }
}
