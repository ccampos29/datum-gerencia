<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;
use common\models\User;

/**
 * This is the model class for table "estados_checklist_configuracion".
 *
 * @property int $id
 * @property int $tipo_checklist_id
 * @property int $estado_checklist_id
 * @property int $porcentaje_maximo_rej
 * @property int $cantidad_maxima_crit
 * @property string $descripcion
 * @property int $empresa_id Relación con empresa
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property TiposChecklist $tipoChecklist
 * @property EstadosChecklist $estadoChecklist
 */
class EstadosChecklistConfiguracion extends MyActiveRecord
{
    public $estado_checklist_nm;
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
        return 'estados_checklist_configuracion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_checklist_id', 'estado_checklist_id'], 'required'],
            [['tipo_checklist_id', 'estado_checklist_id', 'porcentaje_maximo_rej', 'cantidad_maxima_crit'], 'integer'],
            [['descripcion'], 'string'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['tipo_checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposChecklist::className(), 'targetAttribute' => ['tipo_checklist_id' => 'id']],
            [['estado_checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadosChecklist::className(), 'targetAttribute' => ['estado_checklist_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_checklist_id' => 'Tipo Checklist',
            'estado_checklist_id' => 'Estado Checklist',
            'porcentaje_maximo_rej' => 'Porcentaje Maximo Rej',
            'cantidad_maxima_crit' => 'Cantidad Maxima Crit',
            'descripcion' => 'Descripcion',
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
    public function getTipoChecklist()
    {
        return $this->hasOne(TiposChecklist::className(), ['id' => 'tipo_checklist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoChecklist()
    {
        return $this->hasOne(EstadosChecklist::className(), ['id' => 'estado_checklist_id']);
    }
}
