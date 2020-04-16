<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "traslados".
 *
 * @property int $id
 * @property int $ubicacion_origen_id Es la ubicacion origen del repuesto
 * @property int $repuesto_id Es el repuesto que se va a trasladar
 * @property int $ubicacion_destino_id Es la ubicacion destino del repuesto
 * @property int $cantidad Es la cantidad de repuestos a trasladar
 * @property string $fecha_traslado Es la fecha del traslado
 * @property string $observacion Es una pequeña observacion del traslado
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relacion con Empresa
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property UbicacionesInsumos $ubicacionDestino
 * @property UbicacionesInsumos $ubicacionOrigen
 * @property Repuestos $repuesto
 */
class Traslados extends MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'traslados';
    }

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
        return parent::find()->andFilterWhere(['empresa_id' =>@Yii::$app->user->identity->empresa_id]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ubicacion_origen_id', 'repuesto_id', 'ubicacion_destino_id', 'cantidad'], 'integer'],
            [['ubicacion_origen_id', 'repuesto_id', 'ubicacion_destino_id', 'cantidad', 'fecha_traslado'], 'required'],
            [['fecha_traslado', 'creado_el', 'actualizado_el'], 'safe'],
            [['observacion'], 'string', 'max' => 355],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['ubicacion_destino_id'], 'exist', 'skipOnError' => true, 'targetClass' => UbicacionesInsumos::className(), 'targetAttribute' => ['ubicacion_destino_id' => 'id']],
            [['ubicacion_origen_id'], 'exist', 'skipOnError' => true, 'targetClass' => UbicacionesInsumos::className(), 'targetAttribute' => ['ubicacion_origen_id' => 'id']],
            [['repuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repuestos::className(), 'targetAttribute' => ['repuesto_id' => 'id']],
            [['ubicacion_origen_id', 'ubicacion_destino_id'], 'validarUbicacion'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ubicacion_origen_id' => 'Ubicacion Origen',
            'repuesto_id' => 'Repuesto',
            'ubicacion_destino_id' => 'Ubicacion Destino',
            'cantidad' => 'Cantidad',
            'fecha_traslado' => 'Fecha Traslado',
            'observacion' => 'Observacion',
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
    public function getUbicacionDestino()
    {
        return $this->hasOne(UbicacionesInsumos::className(), ['id' => 'ubicacion_destino_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacionOrigen()
    {
        return $this->hasOne(UbicacionesInsumos::className(), ['id' => 'ubicacion_origen_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepuesto()
    {
        return $this->hasOne(Repuestos::className(), ['id' => 'repuesto_id']);
    }

    /* Esta funcion se usara para la validacion entre la ubicacion origen y destino del traslado
    */
    public function validarUbicacion()
    {
        $origen = $this->ubicacion_origen_id;
        $destino = $this->ubicacion_destino_id;
        $error = null;
        if (!empty($origen) && !empty($destino)) {
            if ($origen === $destino) {
                $error = 'La ubicacion destino no puede ser igual a la ubicacion de origen';
                $this->addError('ubicacion_destino_id', $error);
            }
        }
    }
}
