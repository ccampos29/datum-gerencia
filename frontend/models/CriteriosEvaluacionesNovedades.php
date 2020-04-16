<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "criterios_evaluaciones_novedades".
 *
 * @property int $id
 * @property int $criterios_evaluaciones_id ID de los criterios de evaluacion
 * @property int $novedades_id ID de las novedades
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property CriteriosEvaluaciones $criteriosEvaluaciones
 * @property Novedades $novedades
 */
class CriteriosEvaluacionesNovedades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'criterios_evaluaciones_novedades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['criterios_evaluaciones_id', 'novedades_id', 'creado_por', 'creado_el', 'actualizado_por', 'actualizado_el'], 'required'],
            [['criterios_evaluaciones_id', 'novedades_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['criterios_evaluaciones_id'], 'exist', 'skipOnError' => true, 'targetClass' => CriteriosEvaluaciones::className(), 'targetAttribute' => ['criterios_evaluaciones_id' => 'id']],
            [['novedades_id'], 'exist', 'skipOnError' => true, 'targetClass' => Novedades::className(), 'targetAttribute' => ['novedades_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'criterios_evaluaciones_id' => 'Criterios Evaluaciones ID',
            'novedades_id' => 'Novedades ID',
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
    public function getCriteriosEvaluaciones()
    {
        return $this->hasOne(CriteriosEvaluaciones::className(), ['id' => 'criterios_evaluaciones_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedades()
    {
        return $this->hasOne(Novedades::className(), ['id' => 'novedades_id']);
    }
}
