<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use common\models\User;
use Yii;

/**
 * This is the model class for table "estados_checklist_personal".
 *
 * @property int $id
 * @property int $estado_checklist_id Relacion con estados_checklist
 * @property int $usuario_id Relacion con usuarios
 * @property string $email Email del usuario
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 * @property int $tipo_usuario_id Relacion con usuarios
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property User $usuario
 * @property EstadosChecklist $estadoChecklist
 * @property TiposUsuarios $tipoUsuario
 */
class EstadosChecklistPersonal extends MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estados_checklist_personal';
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
            [['estado_checklist_id', 'usuario_id', 'email', 'tipo_usuario_id'], 'required'],
            [['estado_checklist_id', 'usuario_id', 'creado_por', 'actualizado_por', 'empresa_id', 'tipo_usuario_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['email'], 'string', 'max' => 255],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['estado_checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadosChecklist::className(), 'targetAttribute' => ['estado_checklist_id' => 'id']],
            [['tipo_usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposUsuarios::className(), 'targetAttribute' => ['tipo_usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estado_checklist_id' => 'Estado del checklist',
            'usuario_id' => 'Usuario',
            'email' => 'Email',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
            'tipo_usuario_id' => 'Tipo de usuario',
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
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoChecklist()
    {
        return $this->hasOne(EstadosChecklist::className(), ['id' => 'estado_checklist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoUsuario()
    {
        return $this->hasOne(TiposUsuarios::className(), ['id' => 'tipo_usuario_id']);
    }
}
