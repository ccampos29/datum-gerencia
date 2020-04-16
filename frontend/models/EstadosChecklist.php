<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "estados_checklist".
 *
 * @property int $id
 * @property string $estado Estado del checklist
 * @property int $codigo Codigo del estado para un checklist
 * @property int $dias_alerta Dias para enviar email de alerta sobre la realizacion de un checklist
 * @property string $descripcion Descripcion del estado del cheklist
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class EstadosChecklist extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estados_checklist';
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
    /*public static function find()
    {
        return parent::find()->andFilterWhere(['empresa_id' =>@Yii::$app->user->identity->empresa_id]);
    }*/
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'dias_alerta', 'creado_por', 'actualizado_por'], 'integer'],
            [['dias_alerta'], 'required'],
            [['dias_alerta'], 'integer', 'min' => 0],
            [['descripcion'], 'string'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['estado'], 'string', 'max' => 255],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estado' => 'Estado',
            'codigo' => 'Codigo',
            'dias_alerta' => 'Dias Alerta',
            'descripcion' => 'Descripcion',
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
    public function getEstadosChecklistPersonals()
    {
        return $this->hasMany(EstadosChecklistPersonal::className(), ['estado_checklist_id' => 'id']);
    }
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getChecklists() 
    { 
        return $this->hasMany(Checklist::className(), ['estado_checklist_id' => 'id']); 
    }

    /**
     * Permite saber si un Trabajo se puede eliminar
     * 
     * @return boolean TRUE si se puede eliminar, FALSE de lo contrario
     */
    public function sePuedeEliminar()
    {
        if ($this->estadosChecklistPersonals) {
            return false;
        }
        if($this->checklists)
            return false;
        return true;
    }

    /**
     * Objetos que están relacionados a través de otros objetos, modelos o tablas
     * que restringen el delete
     * 
     * @return string detalle de los objetos con los cuales está relacionado
     */
    public function objetosRelacionados()
    {
        $detalle = '<ul>';

        if ($this->estadosChecklistPersonals) {
            $detalle .= '<li>Se debe eliminar los estados de checklist personales relacionados</li>';
        }
        if ($this->checklists) {
            $detalle .= '<li>Se debe eliminar los checklist relacionados</li>';
        }

        $detalle .= '</ul>';
        return $detalle;
    }
}
