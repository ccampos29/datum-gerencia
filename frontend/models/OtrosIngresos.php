<?php

namespace frontend\models;
use common\models\User;
use common\models\MyActiveRecord;
use Yii;

/**
 * This is the model class for table "otros_ingresos".
 *
 * @property int $id
 * @property float $valor_ingreso ato que contiene el valor del ingreso generado
 * @property string $fecha Fecha del ingreso
 * @property string $observacion Observación del ingreso cargado
 * @property int $vehiculo_id Dato intermedio entre otros_ingresos y vehiculos
 * @property int $tipo_ingreso_id Dato intermedio entre otros_ingresos y tipos_ingresos
 * @property int $cliente_id
 * @property string|null $codigo
 * @property int|null $empresa_id
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property Empresas $empresa
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Vehiculos $vehiculo
 * @property TiposIngresos $tipoIngreso
 */

class OtrosIngresos extends \common\models\MyActiveRecord
{
    public $total_cost;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'otros_ingresos';
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
            [['valor_ingreso', 'fecha', 'observacion', 'vehiculo_id', 'tipo_ingreso_id', 'cliente_id'], 'required'],
            [['valor_ingreso'], 'number'],
            [['fecha', 'creado_el', 'actualizado_el'], 'safe'],
            [['observacion'], 'string'],
            [['vehiculo_id', 'tipo_ingreso_id', 'cliente_id', 'empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['codigo'], 'string', 'max' => 20],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['tipo_ingreso_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposIngresos::className(), 'targetAttribute' => ['tipo_ingreso_id' => 'id']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['cliente_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor_ingreso' => 'Valor Ingreso',
            'fecha' => 'Fecha',
            'observacion' => 'Observacion',
            'vehiculo_id' => 'Vehiculo',
            'tipo_ingreso_id' => 'Tipo del ingreso',
            'cliente_id' => 'Cliente',
            'codigo' => 'Codigo',
            'empresa_id' => 'Empresa',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
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
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculos::className(), ['id' => 'vehiculo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoIngreso()
    {
        return $this->hasOne(TiposIngresos::className(), ['id' => 'tipo_ingreso_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Clientes::className(), ['id' => 'cliente_id']);
    }
}
