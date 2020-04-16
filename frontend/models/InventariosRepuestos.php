<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "inventarios_repuestos".
 *
 * @property int $id
 * @property int $inventario_id Dato intermedio del inventario
 * @property int $repuesto_id Dato intermedio del repuesto
 * @property int $cantidad_fisica Es la cantidad en el inventario
 * @property int $cantidad_virtual Es la cantidad que hay en el inventario virtual
 * @property int $valor_unitario Es el valor del repuesto
 * @property string $observacion Descripcion del repuesto
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relacion con Empresa
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Inventarios $inventario
 * @property Repuestos $repuesto
 * @property Empresas $empresa
 */
class InventariosRepuestos extends MyActiveRecord
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
        return parent::find()->andFilterWhere(['inventarios_repuestos.empresa_id'=>@Yii::$app->user->identity->empresa_id]);
    }

    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventarios_repuestos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inventario_id', 'cantidad_fisica'], 'required'],
            [['inventario_id', 'repuesto_id', 'cantidad_fisica', 'unidad_medida_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['observacion'], 'string', 'max' => 355],
            [['inventario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Inventarios::className(), 'targetAttribute' => ['inventario_id' => 'id']],
            [['repuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repuestos::className(), 'targetAttribute' => ['repuesto_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['unidad_medida_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnidadesMedidas::className(), 'targetAttribute' => ['unidad_medida_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inventario_id' => 'Inventario',
            'repuesto_id' => 'Repuesto',
            'cantidad_fisica' => 'Cantidad Fisica',
            'unidad_medida_id' => 'Unidad Medida',
            'observacion' => 'Observacion',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
        ];
    }

    /**
     * Gets query for [[Inventario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInventario()
    {
        return $this->hasOne(Inventarios::className(), ['id' => 'inventario_id']);
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
     * Gets query for [[UnidadMedida]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnidadMedida()
    {
        return $this->hasOne(UnidadesMedidas::className(), ['id' => 'unidad_medida_id']);
    }
}
