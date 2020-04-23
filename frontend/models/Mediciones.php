<?php

namespace frontend\models;

use common\models\User;
use common\models\MyActiveRecord;


use Yii;

/**
 * This is the model class for table "mediciones".
 *
 * @property int $id
 * @property string $fecha_medicion Fecha de la medicion
 * @property string $hora_medicion Hora de la medicion
 * @property float $valor_medicion Dato cargado por web service sobre la cantidad de km recorridos por un vehiculo
 * @property string $estado_vehiculo Estado en el que se encuentra un vehiculo
 * @property string|null $observacion Observación de la medicion cargada
 * @property int $vehiculo_id Dato intermedio entre mediciones y vehiculos
 * @property int $usuario_id Dato intermedio entre mediciones y empleados
 * @property string $tipo_medicion Dato que refleja el tipo de medicion usada por el vehiculo
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 * @property string $proviene_de 'Dato que refleja de donde proviene la medicion
 *
 * @property User $creadoPor
 * @property User $usuario
 * @property Empresas $empresa
 * @property User $actualizadoPor
 * @property Vehiculos $vehiculo
 */
class Mediciones extends MyActiveRecord
{
    public $fecha_1, $fecha_2;
    public $medicion;
    public $kms_recorrido, $dias_recorridos,$promedio_dias_recorridos;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mediciones';
    }
    /**
     * Registra y/o Modifica la empresa en el modelo, según la empresa del usuario logueado
     * @param string $insert Query de inserción
     * @return mixed[]
     */
    public function beforeSave($insert) {
        if(isset(Yii::$app->user->identity->empresa_id)){
            $this->empresa_id = Yii::$app->user->identity->empresa_id;
        }
        return parent::beforeSave($insert);
    }
    /**
     * Sobreescritura del método find para que siempre filtre por la empresa del usuario logueado
     * @return array Arreglo filtrado por empresa
     */
    public static function find()
    {
        return parent::find()->andFilterWhere(['mediciones.empresa_id' =>@Yii::$app->user->identity->empresa_id]);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_medicion', 'hora_medicion', 'valor_medicion', 'estado_vehiculo', 'vehiculo_id', 'usuario_id', 'tipo_medicion', 'proviene_de'], 'required'],
            [['fecha_medicion', 'hora_medicion', 'creado_el', 'actualizado_el'], 'safe'],
            [['valor_medicion'], 'number'],
            [['observacion'], 'string'],
            [['vehiculo_id', 'usuario_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['estado_vehiculo', 'tipo_medicion', 'proviene_de'], 'string', 'max' => 255],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_medicion' => 'Fecha de la medicion',
            'hora_medicion' => 'Hora de la medicion',
            'valor_medicion' => 'Valor de la medicion',
            'estado_vehiculo' => 'Estado del vehiculo',
            'observacion' => 'Observacion',
            'vehiculo_id' => 'Vehiculo',
            'usuario_id' => 'Usuario',
            'tipo_medicion' => 'Tipo de la medicion',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa',
            'proviene_de' => 'Proviene de',
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
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id']);
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
    public function getActualizadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculos::className(), ['id' => 'vehiculo_id']);
    }


    /* Esta funcion se usara para almacenar en la tabla mediciones, el registro
    * que se genera al cargar el valor del web service en el sistema.
    *@Param $q 
    */
    public function almacenarMedicion($q, $idVehiculo)
    {
        $medicion = new Mediciones();
        $medicion->fecha_medicion = $q['fecha'];
        $medicion->hora_medicion = $q['hora'];
        if($q['function']=='horom'){
            $medicion->valor_medicion = round($q['valor']/60);
        
        }else{
            $medicion->valor_medicion = $q['valor'];
        
        }
        $medicion->estado_vehiculo = $q['estado'];
        $medicion->tipo_medicion = $q['tipo'];
        $medicion->vehiculo_id = $idVehiculo;
        $medicion->usuario_id = Yii::$app->user->identity->id;
        $medicion->proviene_de = 'Web Service';
        if (!$medicion->save()) {
            print_r($medicion->getErrors());
            die();
        }
    }
}
