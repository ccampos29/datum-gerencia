<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "checklist".
 *
 * @property int $id
 * @property string|null $fecha_siguente Fecha tentativa del siguente checklist
 * @property string $fecha_checklist Fecha de realizacion del checklist
 * @property string $hora_medicion Hora de realizacion del checklist
 * @property string|null $fecha_anulado Fecha de anulacion del checklist
 * @property float|null $medicion_siguente Medicion tentativa para la realizacion del siguiente checklist
 * @property string|null $observacion Observación del checklist cargado
 * @property int $vehiculo_id Dato intermedio entre checklist y vehiculo_id
 * @property int|null $tipo_checklist_id Dato intermedio entre checklist y tipos_checklist
 * @property int $medicion_actual Medicion actual traida consumida del web service
 * @property int $usuario_id Dato intermedio entre checklist y empleados
 * @property int $estado_checklist_id
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 *
 * @property CalificacionesChecklist[] $calificacionesChecklists
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Vehiculos $vehiculo
 * @property TiposChecklist $tipoChecklist
 * @property User $usuario
 * @property Empresas $empresa
 */
class Checklist extends \common\models\MyActiveRecord
{
    public $imagenChecklist;
    public $calificacion;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'checklist';
    }
    /**
     * Registra y/o Modifica la empresa en el modelo, según la empresa del usuario logueado
     * @param string $insert Query de inserción
     * @return mixed[]
     */
    public function beforeSave($insert)
    {
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
        return parent::find()->andFilterWhere(['empresa_id' => @Yii::$app->user->identity->empresa_id]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_siguente', 'fecha_checklist', 'hora_medicion', 'fecha_anulado', 'creado_el', 'actualizado_el'], 'safe'],
            [['fecha_checklist', 'hora_medicion', 'vehiculo_id', 'medicion_actual', 'usuario_id', 'tipo_checklist_id'], 'required'],
            [['medicion_siguente'], 'number'],
            [['observacion', 'estado'], 'string'],
            [['vehiculo_id', 'tipo_checklist_id', 'medicion_actual', 'usuario_id', 'consecutivo', 'creado_por', 'actualizado_por', 'empresa_id', 'estado_checklist_id'], 'integer'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['tipo_checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposChecklist::className(), 'targetAttribute' => ['tipo_checklist_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['estado_checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadosChecklist::className(), 'targetAttribute' => ['estado_checklist_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID de Checklist',
            'fecha_siguente' => 'Fecha Siguente',
            'fecha_checklist' => 'Fecha Checklist',
            'hora_medicion' => 'Hora Medicion',
            'fecha_anulado' => 'Fecha Anulado',
            'medicion_siguente' => 'Medicion Siguente',
            'observacion' => 'Observacion',
            'vehiculo_id' => 'Vehiculo',
            'tipo_checklist_id' => 'Tipo checklist',
            'medicion_actual' => 'Medicion Actual',
            'usuario_id' => 'Usuario',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa',
            'estado' => 'Calificacion del Checklist',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacionesChecklists()
    {
        return $this->hasMany(CalificacionesChecklist::className(), ['checklist_id' => 'id']);
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
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculos::className(), ['id' => 'vehiculo_id']);
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
    public function getEstadoChecklist()
    {
        return $this->hasOne(EstadosChecklist::className(), ['id' => 'estado_checklist_id']);
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
        $medicion->proviene_de = 'Checklist';
        if (!$medicion->save()) {
            print_r($medicion->getErrors());
            die();
        }
    }

    /* Esta funcion se usara para la validacion entre los 
        rangos de las fechas de expedicion, vigencia y expiracion del seguro
    */
    public function validarFechas()
    {
        $fechaChecklist = strtotime($this->fecha_checklist);
        $fechaAnulado = strtotime($this->fecha_anulado);
        $fechaSiguente = strtotime($this->fecha_siguente);

        $error = null;
        if (!empty($fechaChecklist) && !empty($fechaAnulado)) {
            if ($fechaAnulado < $fechaChecklist) {
                $error = 'La fecha de anulacion no puede ser menor que la fecha del checklist.';
                $this->addError('fecha_expiracion', $error);
            }
        }
        if (!empty($fechaSiguente) && !empty($fechaChecklist)) {
            if ($fechaSiguente < $fechaChecklist) {
                $error = 'La fecha del siguiente checklist no puede ser menor que la fecha del checklist.';
                $this->addError('fecha_siguiente', $error);
            }
            /*if ($fechaSiguente == $fechaChecklist) {
                $error = 'La fecha de vigencia no puede ser igual a la fecha de expedicion.';
                $this->addError('fecha_vigencia', $error);
            }*/
        }
    
    }    
    public function antesDelete()
    {
        $imagenes = ImagenesChecklist::find()->where(['checklist_id'=>$this->id])->all();
        foreach ($imagenes as $imagen) {
            if(!empty($imagen)){
                $imagen->delete();
            }
            
        }
        $calificaciones = CalificacionesChecklist::find()->where(['checklist_id'=>$this->id])->all();
        foreach ($calificaciones as $calificacion) {
            if(!empty($calificacion)){
                $calificacion->delete();
            }
            
        }
    }

    public function asociarCalificaciones($idChecklist,$param){
        $model = Checklist::findOne($idChecklist);
        $model->updateAttributes(['estado' => $param]);
    }
}
