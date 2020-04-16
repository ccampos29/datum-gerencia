<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "tipos_checklist".
 *
 * @property int $id
 * @property string $nombre Nombre del checklist
 * @property int $tipo_vehiculo_id Relación con el tipo de vehiculos a los cuales se les puede hacer este checklist
 * @property string|null $codigo Codigo del checklist
 * @property int $dias Periodicidad con la cual se debe hacer este checklist
 * @property int $horas Aquí se debe almacenar la cantidad que define cada cuanto se hace el checklist, en este caso si selecciono días debo indicar cada cuantos días se realiza este checklist, si selecciono odometro debo poner cada cuantos kilometros se debe hacer, etc
 * @property int|null $odometro
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 *
 * @property CalificacionesChecklist[] $calificacionesChecklists
 * @property Checklist[] $checklists
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property TiposVehiculos $tipoVehiculo
 * @property Empresas $empresa
 */
class TiposChecklist extends \common\models\MyActiveRecord
{
    public $tipo_vehiculo_id;
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
    public function afterFind() {
        parent::afterFind();
         $detalle = [];
        foreach ($this->tiposChecklistDetalle as $tag) {
            $detalle[] = $tag->tipo_vehiculo_id;
        } 
        $this->tipo_vehiculo_id = $detalle;
        
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipos_checklist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'tipo_vehiculo_id'], 'required'],
            [[ 'dias', 'horas', 'odometro', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
            [['codigo'], 'string', 'max' => 20],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            ['nombre', 'unique']

/*             [['dias','compare','compareAttribute'=>'horas','operator','>','message'=>'Start Date must be less than End Date']]
 */        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'tipo_vehiculo_id' => 'Tipo Vehiculo',
            'codigo' => 'Codigo',
            'dias' => 'Dias',
            'horas' => 'Horas',
            'odometro' => 'Periodicidad en Kilómetros',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa',
        ];
    }


    /* Esta funcion se usara para la validacion entre los 
        rangos de las fechas de expedicion, vigencia y expiracion del seguro
    */
/*     public function validarFechas()
    {
        $dias = ($this->dias);
        $horas = ($this->horas);

        $error = null;

        
        if (!empty($dias) && !empty($horas) and $this->odometro) {
            if ($fechaExpiracion < $fechaExpedicion) {
                $error = 'La fecha de expiracion no puede ser menor que la fecha de expedicion.';
                $this->addError('fecha_expiracion', $error);
            }
            if ($fechaExpiracion == $fechaExpedicion) {
                $error = 'La fecha de expiracion no puede ser igual a la fecha de expedicion.';
                $this->addError('fecha_expiracion', $error);
            }
        }
        if (!empty($fechaVigencia) && !empty($fechaExpiracion)) {
            if ($fechaVigencia < $fechaExpedicion) {
                $error = 'La fecha de vigencia no puede ser menor que la fecha de expedicion.';
                $this->addError('fecha_vigencia', $error);
            }

        }
    
    }
 */
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacionesChecklists()
    {
        return $this->hasMany(CalificacionesChecklist::className(), ['tipo_checklist_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklists()
    {
        return $this->hasMany(Checklist::className(), ['tipo_checklist_id' => 'id']);
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
    public function getTiposChecklistDetalle()
    {
        return $this->hasMany(TiposChecklistDetalle::className(), ['tipo_checklist_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['id' => 'empresa_id']);
    }
}
