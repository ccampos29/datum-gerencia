<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;
use common\models\User;

/**
 * This is the model class for table "alertas_usuarios".
 *
 * @property int $id
 * @property int $user_id
 * @property int $tipo_alerta_id
 * @property int $empresa_id Relación con empresa
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Empresas $empresa
 * @property AlertasTipos $tipoAlerta
 * @property User $user
 */
class AlertasUsuarios extends MyActiveRecord
{
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
        return 'alertas_usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'tipo_alerta_id'], 'required'],
            [['user_id', 'tipo_alerta_id', 'empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['tipo_alerta_id'], 'exist', 'skipOnError' => true, 'targetClass' => AlertasTipos::className(), 'targetAttribute' => ['tipo_alerta_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Usuario',
            'tipo_alerta_id' => 'Tipo de alerta',
            'empresa_id' => 'Empresa',
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
    public function getTipoAlerta()
    {
        return $this->hasOne(AlertasTipos::className(), ['id' => 'tipo_alerta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
}
