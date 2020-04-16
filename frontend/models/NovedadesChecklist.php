<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "novedades_checklist".
 *
 * @property string $id
 * @property string $calificacion Relación con el grupo de novedades
 * @property string $trabajo_id Criterio de evaluación aplicado a esta novedad
 * @property string $empresa_id Relación con empresa
 * @property string $prioridad
 * @property string $novedad_id
 * @property string $id_criterio_evaluacion_det
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 *
 * @property EstadosChecklist $calificacion0
 * @property Empresas $empresa
 * @property Trabajos $trabajo
 * @property CriteriosEvaluacionesDetalle $criterioEvaluacionDet
 * @property Novedades $novedad
 */
class NovedadesChecklist extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'novedades_checklist';
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
            [['id', 'calificacion', 'trabajo_id',  'novedad_id', 'id_criterio_evaluacion_det', ], 'integer'],
            [['prioridad'], 'string'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['empresa_id', 'novedad_id', 'id_criterio_evaluacion_det'], 'unique', 'targetAttribute' => ['empresa_id', 'novedad_id', 'id_criterio_evaluacion_det']],
            [['calificacion'], 'exist', 'skipOnError' => true, 'targetClass' => EstadosChecklist::className(), 'targetAttribute' => ['calificacion' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['trabajo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajos::className(), 'targetAttribute' => ['trabajo_id' => 'id']],
           // [['id_criterio_evaluacion_det'], 'exist', 'skipOnError' => true, 'targetClass' => CriteriosEvaluacionesDetalle::className(), 'targetAttribute' => ['id_criterio_evaluacion_det' => 'id']],
            [['novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Novedades::className(), 'targetAttribute' => ['novedad_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calificacion' => 'Calificacion',
            'trabajo_id' => 'Trabajo ID',
            'empresa_id' => 'Empresa ID',
            'prioridad' => 'Prioridad',
            'novedad_id' => 'Novedad ID',
            'id_criterio_evaluacion_det' => 'Id Criterio Evaluacion Det',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacion0()
    {
        return $this->hasOne(EstadosChecklist::className(), ['id' => 'calificacion']);
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
    public function getTrabajo()
    {
        return $this->hasOne(Trabajos::className(), ['id' => 'trabajo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriterioEvaluacionDet()
    {
        return $this->hasOne(CriteriosEvaluacionesDetalle::className(), ['id' => 'id_criterio_evaluacion_det']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedad()
    {
        return $this->hasOne(Novedades::className(), ['id' => 'novedad_id']);
    }
}
