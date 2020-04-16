<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "novedades".
 *
 * @property string $id
 * @property string $nombre Nombre de la novedad
 * @property string $grupo_novedad_id Relación con el grupo de novedades
 * @property string $criterio_evaluacion_id Criterio de evaluación aplicado a esta novedad
 * @property string $observacion Observación para esta novedad
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property GruposNovedades $grupoNovedad
 * @property CriteriosEvaluaciones $criterioEvaluacion
 */
class Novedades extends \common\models\MyActiveRecord
{
    public $novedades_checklist,$detalle,$calificacion,$trabajo,$prioridad, $tipo_checklist_id;
    public $rango_minimo,$rango_maximo;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'novedades';
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
            [['nombre', 'grupo_novedad_id', 'criterio_evaluacion_id','genera_novedades', 'activo'], 'required'],
            [['grupo_novedad_id', 'criterio_evaluacion_id', 'creado_por', 'actualizado_por','genera_novedades', 'activo'], 'integer'],
            [['observacion'], 'string'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['grupo_novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => GruposNovedades::className(), 'targetAttribute' => ['grupo_novedad_id' => 'id']],
            [['criterio_evaluacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => CriteriosEvaluaciones::className(), 'targetAttribute' => ['criterio_evaluacion_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'genera_novedades' => 'Genera Novedades',
            'activo' => 'Activo',
            'nombre' => 'Nombre',
            'grupo_novedad_id' => 'Grupo Novedad',
            'criterio_evaluacion_id' => 'Criterio Evaluacion',
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
    public function getGrupoNovedad()
    {
        return $this->hasOne(GruposNovedades::className(), ['id' => 'grupo_novedad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriterioEvaluacion()
    {
        return $this->hasOne(CriteriosEvaluaciones::className(), ['id' => 'criterio_evaluacion_id']);
    }
}
