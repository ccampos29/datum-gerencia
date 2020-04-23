<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "novedades_mantenimientos".
 *
 * @property int $id
 * @property int $vehiculo_id Es el automovil al que se le reporta la novedad
 * @property string $fecha_reporte Es la fecha de cuando se hizo la novedad
 * @property string $hora_reporte Es la hora de cuando se hizo la novedad
 * @property int $usuario_reporte_id Es el usuario que generó la novedad
 * @property int $prioridad_id Indica que tan prioritaria es la novedad
 * @property int $medicion Es el kilometraje del odometro
 * @property int $usuario_responsable_id Es el usuario responsable del mantenimiento
 * @property int $trabajo_id Es el trabajo a realizar en el mantenimiento
 * @property string $observacion Es una pequeña descripcion de la novedad
 * @property string $fecha_solucion Es la fecha de cuando se quiere tener el mantenimiento ejecutado
 * @property string $estado Determina si la novedad ya fue solucionada o no
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property PrioridadesMantenimientos $prioridad
 * @property Trabajos $trabajo
 * @property User $usuarioReporte
 * @property User $usuarioResponsable
 * @property Vehiculos $vehiculo
 */
class NovedadesMantenimientos extends MyActiveRecord
{

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
        return parent::find()->andFilterWhere(['empresa_id'=>@Yii::$app->user->identity->empresa_id]);
    }

    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'novedades_mantenimientos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehiculo_id', 'fecha_hora_reporte', 'usuario_reporte_id', 'prioridad_id'], 'required'],
            [['vehiculo_id', 'usuario_reporte_id', 'prioridad_id', 'medicion', 'usuario_responsable_id', 'trabajo_id', 'checklist_id', 'orden_trabajo_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['fecha_hora_reporte', 'fecha_solucion', 'creado_el', 'actualizado_el'], 'safe'],
            [['observacion'], 'string', 'max' => 355],
            [['estado', 'proviene_de'], 'string', 'max' => 255],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['usuario_reporte_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_reporte_id' => 'id']],
            [['usuario_responsable_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_responsable_id' => 'id']],
            [['trabajo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajos::className(), 'targetAttribute' => ['trabajo_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Checklist::className(), 'targetAttribute' => ['checklist_id' => 'id']],
            [['orden_trabajo_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenesTrabajos::className(), 'targetAttribute' => ['orden_trabajo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehiculo_id' => 'Vehiculo',
            'fecha_hora_reporte' => 'Fecha Hora Reporte',
            'usuario_reporte_id' => 'Usuario Reporte',
            'prioridad_id' => 'Prioridad',
            'medicion' => 'Medicion',
            'usuario_responsable_id' => 'Usuario Responsable',
            'trabajo_id' => 'Trabajo',
            'observacion' => 'Observacion',
            'fecha_solucion' => 'Fecha Solucion',
            'estado' => 'Estado',
            'proviene_de' => 'Proviene De',
            'checklist_id' => 'Checklist',
            'orden_trabajo_id' => 'Orden de Trabajo',
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
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculos::className(), ['id' => 'vehiculo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioReporte()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_reporte_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioResponsable()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_responsable_id']);
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
    public function getChecklist()
    {
        return $this->hasOne(Checklist::className(), ['id' => 'checklist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenTrabajo()
    {
        return $this->hasOne(OrdenesTrabajos::className(), ['id' => 'orden_trabajo_id']);
    }

/**
     * Almacena una medicion a la tabla mediciones
     * @param array $q, $idVehiculo
     */
    public function almacenarMedicion($q, $idVehiculo){
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
        $medicion->proviene_de = 'Novedad de Mantenimiento';
        if (!$medicion->save()) {
            print_r($medicion->getErrors());
            die();
        }
    }
}
