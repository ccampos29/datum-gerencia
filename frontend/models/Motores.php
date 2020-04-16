<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "Motores".
 *
 * @property int $id
 * @property string $marca_motor_id Marca del motor
 * @property string $linea_motor_id Linea del motor, esto debe ser un select dependiente de la marca de motor seleccionada
 * @property string $codigo Codigo del motor
 * @property string $potencia Potencia del motor
 * @property string $torque Torque del motor
 * @property string $rpm Revoluciones por minuto del motor
 * @property string $cilindraje Cilindraje del motor
 * @property string $observacion Observación del motor
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 */
class Motores extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'motores';
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
            [['marca_motor_id', 'linea_motor_id', 'potencia', 'torque', 'rpm', 'cilindraje'], 'required'],
            [['marca_motor_id', 'linea_motor_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['observacion'], 'string'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['codigo'], 'string', 'max' => 20],
            [['potencia', 'torque', 'rpm', 'cilindraje'], 'string', 'max' => 255],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['marca_motor_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarcasMotores::className(), 'targetAttribute' => ['marca_motor_id' => 'id']],
            [['linea_motor_id'], 'exist', 'skipOnError' => true, 'targetClass' => LineasMotores::className(), 'targetAttribute' => ['linea_motor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'marca_motor_id' => 'Marca Motor',
            'linea_motor_id' => 'Linea Motor',
            'codigo' => 'Codigo',
            'potencia' => 'Potencia',
            'torque' => 'Torque',
            'rpm' => 'Rpm',
            'cilindraje' => 'Cilindraje',
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
    public function getMarcaMotor() 
    { 
        return $this->hasOne(MarcasMotores::className(), ['id' => 'marca_motor_id']); 
    } 
    
    /** 
        * @return \yii\db\ActiveQuery 
        */ 
    public function getLineaMotor() 
    { 
        return $this->hasOne(LineasMotores::className(), ['id' => 'linea_motor_id']); 
    } 
}
