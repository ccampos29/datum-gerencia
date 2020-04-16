<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "mantenimientos".
 *
 * @property int $id
 * @property string $descripcion Describe que tipo de mantenimiento se necesita
 * @property string $fecha_ejecucion Es la fecha de cuando se hará el mantenimiento
 * @property string $hora_ejecucion Es la hora de cuando se hará el mantenimiento
 * @property string $estado Determina si el mantenimiento está pendiente, ejecutado o cancelado
 * @property int $medicion Es el kilometraje del odometro
 * @property string $duracion Es el estimado que demora el mantenimiento
 * @property int $vehiculo_id Vehiculo al que va asociado el mantenimiento
 * @property int $trabajo_id Es el trabajo que se requiere hacer en el mantenimiento
 * @property int $tipo_mantenimiento_id Es la categoria del mantenimiento a la que pertenece
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Trabajos $trabajo
 * @property TiposMantenimientos $tipoMantenimiento
 */
class Mantenimientos extends MyActiveRecord
{

    /**
     * Registra y/o Modifica la empresa en el modelo, según la empresa del usuario logueado
     * @param string $insert Query de inserción
     * @return mixed[]
     */
    public function beforeSave($insert)
    {
        $this->empresa_id = Yii::$app->user->identity->empresa_id;
        return parent::beforeSave($insert);
    }
    /**
     * Sobreescritura del método find para que siempre filtre por la empresa del usuario logueado
     * @return array Arreglo filtrado por empresa
     */
    public static function find()
    {
        return parent::find()->andFilterWhere(['empresa_id' => @Yii::$app->user->identity->empresa_id]);
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mantenimientos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'estado', 'vehiculo_id', 'trabajo_id', 'tipo_mantenimiento_id', 'fecha_hora_ejecucion'], 'required'],
            [['fecha_hora_ejecucion', 'creado_el', 'actualizado_el'], 'safe'],
            [['medicion', 'medicion_ejecucion', 'vehiculo_id', 'trabajo_id', 'tipo_mantenimiento_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['descripcion'], 'string', 'max' => 355],
            [['estado'], 'string', 'max' => 255],
            [['duracion'], 'string', 'max' => 20],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['trabajo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajos::className(), 'targetAttribute' => ['trabajo_id' => 'id']],
            [['tipo_mantenimiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposMantenimientos::className(), 'targetAttribute' => ['tipo_mantenimiento_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['medicion', 'medicion_ejecucion'], 'validaciones'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'fecha_hora_ejecucion' => 'Fecha Hora Ejecucion',
            'medicion' => 'Medicion',
            'medicion_ejecucion' => 'Medicion de Ejecucion',
            'estado' => 'Estado',
            'duracion' => 'Duracion',
            'vehiculo_id' => 'Vehiculo',
            'trabajo_id' => 'Trabajo',
            'tipo_mantenimiento_id' => 'Tipo Mantenimiento',
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
    public function getTrabajo()
    {
        return $this->hasOne(Trabajos::className(), ['id' => 'trabajo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoMantenimiento()
    {
        return $this->hasOne(TiposMantenimientos::className(), ['id' => 'tipo_mantenimiento_id']);
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
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculos::className(), ['id' => 'vehiculo_id']);
    }

    /**
     * Almacena una medicion a la tabla mediciones
     * @param array $q, $idVehiculo
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
        $medicion->proviene_de = 'Programar Mantenimiento';
        if (!$medicion->save()) {
            print_r($medicion->getErrors());
            die();
        }
    }

    public function validaciones()
    {
        if (!empty($this->medicion) && !empty($this->medicion_ejecucion)) {
            if ($this->medicion > $this->medicion_ejecucion) {
                $error = 'La medicion de ejecucion no puede ser menor a la medicion actual';
                $this->addError('medicion_ejecucion', $error);
            }
        }
    }
}
