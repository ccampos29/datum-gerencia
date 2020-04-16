<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "cotizaciones_repuestos".
 *
 * @property int $id
 * @property int $cotizacion_id Dato intermedio de las cotizaciones
 * @property int $repuesto_id Dato intermedio de los repuestos
 * @property int $cantidad Es la cantidad de un repuesto
 * @property string $observacion_cliente Es una pequeña descripcion del repuesto segun el cliente que solicito
 * @property int $valor_unitario Es el valor de un repuesto
 * @property string $tipo_descuento Indica si el descuento es porcentaje o valor
 * @property int $descuento_unitario Es el valor del descuento
 * @property int $tipo_impuesto_id Determina que tipo de impuesto aplica
 * @property string $observacion Es una pequeña descripcion del repuesto
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relacion con Empresa
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property Cotizaciones $cotizacion
 * @property Repuestos $repuesto
 * @property TiposImpuestos $tipoImpuesto
 */
class CotizacionesRepuestos extends MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cotizaciones_repuestos';
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
            [['cotizacion_id', 'repuesto_id', 'cantidad', 'valor_unitario', 'descuento_unitario', 'tipo_impuesto_id'], 'required'],
            [['cotizacion_id', 'repuesto_id', 'cantidad', 'valor_unitario', 'tipo_impuesto_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['observacion_cliente', 'observacion'], 'string', 'max' => 355],
            [['tipo_descuento'], 'string', 'max' => 255],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['cotizacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cotizaciones::className(), 'targetAttribute' => ['cotizacion_id' => 'id']],
            [['repuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repuestos::className(), 'targetAttribute' => ['repuesto_id' => 'id']],
            [['tipo_impuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposImpuestos::className(), 'targetAttribute' => ['tipo_impuesto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cotizacion_id' => 'Cotizacion ID',
            'repuesto_id' => 'Repuesto ID',
            'cantidad' => 'Cantidad',
            'observacion_cliente' => 'Observacion Cliente',
            'valor_unitario' => 'Valor Unitario',
            'tipo_descuento' => 'Tipo Descuento',
            'descuento_unitario' => 'Descuento Unitario',
            'tipo_impuesto_id' => 'Tipo Impuesto ID',
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
    public function getCotizacion()
    {
        return $this->hasOne(Cotizaciones::className(), ['id' => 'cotizacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepuesto()
    {
        return $this->hasOne(Repuestos::className(), ['id' => 'repuesto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoImpuesto()
    {
        return $this->hasOne(TiposImpuestos::className(), ['id' => 'tipo_impuesto_id']);
    }
}
