<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "rutinas_repuestos".
 *
 * @property int $id
 * @property int $rutina_id Dato intermedio de la rutina
 * @property int $repuesto_id Dato intermedio del repuesto
 * @property int $rutina_trabajo_id Es el trabajo asociado en la rutina
 * @property int $cantidad Es la cantidad de repuestos
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property RutinasTrabajos $rutinaTrabajo
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Repuestos $repuesto
 * @property Rutinas $rutina
 */
class RutinasRepuestos extends MyActiveRecord
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
        return 'rutinas_repuestos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rutina_id', 'repuesto_id', 'rutina_trabajo_id', 'cantidad'], 'required'],
            [['rutina_id', 'repuesto_id', 'rutina_trabajo_id', 'cantidad', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['rutina_trabajo_id'], 'exist', 'skipOnError' => true, 'targetClass' => RutinasTrabajos::className(), 'targetAttribute' => ['rutina_trabajo_id' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['repuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repuestos::className(), 'targetAttribute' => ['repuesto_id' => 'id']],
            [['rutina_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rutinas::className(), 'targetAttribute' => ['rutina_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rutina_id' => 'Rutina ID',
            'repuesto_id' => 'Repuesto ID',
            'rutina_trabajo_id' => 'Rutina Trabajo ID',
            'cantidad' => 'Cantidad',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinaTrabajo()
    {
        return $this->hasOne(RutinasTrabajos::className(), ['id' => 'rutina_trabajo_id']);
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
    public function getRepuesto()
    {
        return $this->hasOne(Repuestos::className(), ['id' => 'repuesto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutina()
    {
        return $this->hasOne(Rutinas::className(), ['id' => 'rutina_id']);
    }
}
