<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "propiedades_trabajos".
 *
 * @property int $id
 * @property int $tipo_vehiculo_id Dato intermedio del tipo de vehiculo
 * @property int $trabajo_id Dato intermedio del trabajo
 * @property int $duracion Es la duracion del trabajo
 * @property int $costo_mano_obra Es el costo por el trabajo
 * @property int $cantidad Es la cantidad de repuestos asociados
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property TiposVehiculos $tipoVehiculo
 * @property Trabajos $trabajo
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class PropiedadesTrabajos extends MyActiveRecord
{

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
        return parent::find()->andFilterWhere(['empresa_id'=>@Yii::$app->user->identity->empresa_id]);
    }

    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'propiedades_trabajos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_vehiculo_id', 'trabajo_id', 'duracion', 'costo_mano_obra', 'cantidad_trabajo'], 'required'],
            [['tipo_vehiculo_id', 'trabajo_id', 'duracion', 'costo_mano_obra', 'cantidad_trabajo', 'repuesto_id', 'cantidad_repuesto', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['tipo_vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposVehiculos::className(), 'targetAttribute' => ['tipo_vehiculo_id' => 'id']],
            [['trabajo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajos::className(), 'targetAttribute' => ['trabajo_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['repuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repuestos::className(), 'targetAttribute' => ['repuesto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_vehiculo_id' => 'Tipo Vehiculo',
            'trabajo_id' => 'Trabajo',
            'duracion' => 'Duracion',
            'costo_mano_obra' => 'Costo Mano Obra',
            'cantidad_trabajo' => 'Cantidad Trabajo',
            'repuesto_id' => 'Repuesto',
            'cantidad_repuesto' => 'Cantidad Repuesto',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
        ];
    }

    /**
     * Gets query for [[CreadoPor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
    }

    /**
     * Gets query for [[ActualizadoPor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActualizadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }

    /**
     * Gets query for [[TipoVehiculo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoVehiculo()
    {
        return $this->hasOne(TiposVehiculos::className(), ['id' => 'tipo_vehiculo_id']);
    }

    /**
     * Gets query for [[Trabajo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajo()
    {
        return $this->hasOne(Trabajos::className(), ['id' => 'trabajo_id']);
    }

    /**
     * Gets query for [[Empresa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['id' => 'empresa_id']);
    }

    /**
     * Gets query for [[Repuesto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepuesto()
    {
        return $this->hasOne(Repuestos::className(), ['id' => 'repuesto_id']);
    }
}
