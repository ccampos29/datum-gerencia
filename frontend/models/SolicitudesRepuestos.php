<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "solicitudes_repuestos".
 *
 * @property int $id
 * @property int $solicitud_id Dato intermedio de la solicitud
 * @property int $repuesto_id Dato intermedio del repuesto
 * @property int $cantidad Es la cantidad de un repuesto
 * @property int $usuario_reclama_id Dato del usuario que reclama
 * @property string $observacion Es una pequeña descripcion del repuesto
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relacion con Empresa
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property User $usuarioReclama
 * @property Solicitudes $solicitud
 * @property Repuestos $repuesto
 */
class SolicitudesRepuestos extends MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitudes_repuestos';
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
            [['solicitud_id', 'repuesto_id', 'cantidad'], 'required'],
            [['solicitud_id', 'repuesto_id', 'cantidad', 'usuario_reclama_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['observacion'], 'string', 'max' => 355],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['usuario_reclama_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_reclama_id' => 'id']],
            [['solicitud_id'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitudes::className(), 'targetAttribute' => ['solicitud_id' => 'id']],
            [['repuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repuestos::className(), 'targetAttribute' => ['repuesto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'solicitud_id' => 'Solicitud ID',
            'repuesto_id' => 'Repuesto ID',
            'cantidad' => 'Cantidad',
            'usuario_reclama_id' => 'Usuario Reclama ID',
            'observacion' => 'Observacion',
            'estado' => 'Estado',
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
    public function getUsuarioReclama()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_reclama_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitud()
    {
        return $this->hasOne(Solicitudes::className(), ['id' => 'solicitud_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepuesto()
    {
        return $this->hasOne(Repuestos::className(), ['id' => 'repuesto_id']);
    }
}
