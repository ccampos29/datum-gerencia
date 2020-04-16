<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "rutinas_trabajos".
 *
 * @property int $id
 * @property int $rutina_id Dato intermedio de la rutina
 * @property int $trabajo_id Dato intermedio del trabajo
 * @property int $cantidad Es la cantidad de trabajos que se asocian a la rutina
 * @property string $observacion Es una pequeña descripcion del trabajo asociado a la rutina
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Rutinas $rutina
 * @property Trabajos $trabajo
 */
class RutinasTrabajos extends MyActiveRecord
{

    public $cantidadInsumos;

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
        return 'rutinas_trabajos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rutina_id', 'trabajo_id', 'cantidad'], 'required'],
            [['id', 'rutina_id', 'trabajo_id', 'cantidad', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el','cantidadInsumos'], 'safe'],
            [['observacion'], 'string', 'max' => 355],
            [['id'], 'unique'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['rutina_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rutinas::className(), 'targetAttribute' => ['rutina_id' => 'id']],
            [['trabajo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajos::className(), 'targetAttribute' => ['trabajo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rutina_id' => 'Rutina',
            'trabajo_id' => 'Trabajo',
            'cantidad' => 'Cantidad',
            'observacion' => 'Observacion',
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
    public function getRutina()
    {
        return $this->hasOne(Rutinas::className(), ['id' => 'rutina_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajo()
    {
        return $this->hasOne(Trabajos::className(), ['id' => 'trabajo_id']);
    }

    public function getRutinasRepuestos()
    {
        return $this->hasMany(RutinasRepuestos::className(), ['rutina_trabajo_id' => 'id']);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->cantidadInsumos = count($this->rutinasRepuestos);
        // print_r($this->cantidadInsumos);
        // die();
    }

    public function eliminarInsumosRepuestos(){
        foreach($this->rutinasRepuestos as $insumo){
            $insumo->delete();
        }
    }
}
