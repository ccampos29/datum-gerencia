<?php

namespace frontend\models;
use common\models\User;
use Yii;

/**
 * This is the model class for table "criterios_evaluaciones_detalle".
 *
 * @property int $id
 * @property int $tipo_criterio_id Relacion con criterios de evaluacion
 * @property string $detalle Detalle del criterio
 * @property float|null $rango Valor del rango para el tipo de criterio que lo necesite
 * @property float|null $minimo Valor minimo del rango para el tipo de criterio que lo necesite
 * @property float|null $maximo Valor maximo del rango para el tipo de criterio que lo necesite
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property CriteriosEvaluaciones $tipoCriterio
 */
class CriteriosEvaluacionesDetalle extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'criterios_evaluaciones_detalle';
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
   /*  public static function find()
    {
        return parent::find()->andFilterWhere(['empresa_id' =>@Yii::$app->user->identity->empresa_id]);
    } */

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_criterio_id', 'detalle'], 'required'],
            [['tipo_criterio_id'], 'integer'],
            [['rango', 'minimo', 'maximo'], 'number'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['detalle'], 'string', 'max' => 255],
           // [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
           // [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
           // [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            //[['tipo_criterio_id'], 'exist', 'skipOnError' => true, 'targetClass' => CriteriosEvaluaciones::className(), 'targetAttribute' => ['tipo_criterio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_criterio_id' => 'Tipo del criterio',
            'detalle' => 'Detalle',
            'rango' => 'Rango',
            'minimo' => 'Minimo',
            'maximo' => 'Maximo',
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
    public function getTipoCriterio()
    {
        return $this->hasOne(CriteriosEvaluaciones::className(), ['id' => 'tipo_criterio_id']);
    }
}
