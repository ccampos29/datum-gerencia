<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "tipos_vehiculos".
 *
 * @property int $id
 * @property string $descripcion Descripción del tipo de vehiculo
 * @property string $codigo Codigo para la descripción del tipo de vehiculo
 * @property string $clase Clase del tipo de vehiculo
 * @property int $promedio_recorrido_dia Promedio del recorrido que genera un tipo de vehiculo, se recomienda unidad de medida en kilometros
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property TiposChecklist[] $tiposChecklists
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class TiposVehiculos extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipos_vehiculos';
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
            [['descripcion', 'clase', 'promedio_recorrido_dia'], 'required'],
            [['clase'], 'string'],
            [['promedio_recorrido_dia', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['descripcion'], 'string', 'max' => 255],
            [['codigo'], 'string', 'max' => 20],
            ['codigo', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Por favor sólo ingrese números.'],
            ['promedio_recorrido_dia','integer','min' => 0],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
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
            'codigo' => 'Codigo',
            'clase' => 'Clase',
            'promedio_recorrido_dia' => 'Promedio Recorrido Dia',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropiedadesTrabajos()
    {
        return $this->hasMany(PropiedadesTrabajos::className(), ['tipo_vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposChecklists()
    {
        return $this->hasMany(TiposChecklist::className(), ['tipo_vehiculo_id' => 'id']);
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
}
