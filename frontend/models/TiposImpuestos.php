<?php

namespace frontend\models;
use Yii;
use common\models\User;

/**
 * This is the model class for table "tipos_impuestos".
 *
 * @property string $id
 * @property string $nombre Nombre del tipo de impuesto
 * @property string $codigo Codigo para el tipo de impuesto
 * @property string $descripcion Descripción del tipo de impuesto
 * @property int $dias_alerta Dias para alertar antes de que se cumpla el tipo de impuesto
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class TiposImpuestos extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipos_impuestos';
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
            [['nombre', 'dias_alerta'], 'required'],
            ['codigo', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Por favor sólo ingrese números.'],
            ['dias_alerta','integer','min' => 0],
            [['descripcion'], 'string'],
            [['dias_alerta', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre'], 'string', 'max' => 355],
            [['codigo'], 'string', 'max' => 20],
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
            'nombre' => 'Nombre',
            'codigo' => 'Codigo',
            'descripcion' => 'Descripcion',
            'dias_alerta' => 'Dias Alerta',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComprasRepuestos()
    {
        return $this->hasMany(ComprasRepuestos::className(), ['tipo_impuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacionesRepuestos()
    {
        return $this->hasMany(CotizacionesRepuestos::className(), ['tipo_impuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacionesTrabajos()
    {
        return $this->hasMany(CotizacionesTrabajos::className(), ['tipo_impuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesComprasRepuestos()
    {
        return $this->hasMany(OrdenesComprasRepuestos::className(), ['tipo_impuesto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOtrosGastos()
    {
        return $this->hasMany(OtrosGastos::className(), ['tipo_impuesto_id' => 'id']);
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
    public function getVehiculosImpuestos()
    {
        return $this->hasMany(VehiculosImpuestos::className(), ['tipo_impuesto_id' => 'id']);
    }
}
