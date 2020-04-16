<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "repuestos_proveedores".
 *
 * @property int $id
 * @property int $repuesto_id Dato intermedio del repuesto
 * @property int $proveedor_id Dato intermedio del proveedor
 * @property int $valor Es el valor del repuesto segun el proveedor
 * @property int $impuesto_id Es el impuesto que se le aplica al repuesto
 * @property int $descuento_repuesto Es el descuento que se le aplica al repuesto
 * @property string $tipo_descuento Especifica si el descuento es en valor($) o en porcentaje(%)
 * @property string $codigo Es el codigo especifico de cada empresa para cada cotizacion del proveedor
 * @property int $plazo_pago Es el plazo en dias para pagar el repuesto
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property Repuestos $repuesto
 * @property Proveedores $proveedor
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class RepuestosProveedores extends MyActiveRecord
{

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
    public static function tableName()
    {
        return 'repuestos_proveedores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['repuesto_id', 'proveedor_id', 'impuesto_id', 'valor'], 'required'],
            [['proveedor_id', 'valor', 'impuesto_id', 'descuento_repuesto', 'plazo_pago', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['tipo_descuento'], 'string', 'max' => 5],
            [['codigo'], 'string', 'max' => 20],
            [['repuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repuestos::className(), 'targetAttribute' => ['repuesto_id' => 'id']],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['valor', 'descuento_repuesto', 'tipo_descuento'], 'validador'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'repuesto_id' => 'Repuesto',
            'proveedor_id' => 'Proveedor',
            'valor' => 'Valor',
            'impuesto_id' => 'Impuesto',
            'descuento_repuesto' => 'Descuento Repuesto',
            'tipo_descuento' => 'Tipo Descuento',
            'codigo' => 'Codigo',
            'plazo_pago' => 'Plazo Pago(Dias)',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
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
    public function getProveedor()
    {
        return $this->hasOne(Proveedores::className(), ['id' => 'proveedor_id']);
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
    public function getImpuesto()
    {
        return $this->hasOne(TiposImpuestos::className(), ['id' => 'impuesto_id']);
    }

    public function validador()
    {
        $error = null;
        if (!empty($this->tipo_descuento && !empty($this->descuento_repuesto))) {
            if ($this->tipo_descuento == 1) {
                if ($this->descuento_repuesto > 100) {
                    $error = 'El descuento no puede ser mayor a 100';
                    $this->addError('descuento_repuesto', $error);
                }
            } else {
                if ($this->descuento_repuesto > $this->valor) {
                    $error = 'El descuento no puede ser mayor al valor del repuesto';
                    $this->addError('descuento_repuesto', $error);
                }
            }
        }
    }
}
