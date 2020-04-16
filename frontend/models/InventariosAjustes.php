<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "inventarios_ajustes".
 *
 * @property int $id
 * @property int $repuesto_id Relacion entre repuestos_inventarios y inventario_ajustes
 * @property int $ubicacion_inventario_id Relacion entre ubicacion_inventario y inventario_ajustes
 * @property int $cantidad_repuesto Cantidad de los repuestos
 * @property int $concepto_id Relacion entre conceptos e inventario_ajustes
 * @property string $observaciones Observaciones de los ajustes del inventario
 * @property string $fecha_ajuste Fecha y hora del ajuste
 * @property int $usuario_id Relacion entre usuarios e inventarios_ajustes
 * @property int $empresa_id Relacion entre empresas e inventarios_ajustes
 * @property int $saldo
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property Conceptos $concepto
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property UbicacionesInsumos $ubicacionInventario
 * @property User $usuario
 * @property Repuestos $repuesto
 */
class InventariosAjustes extends MyActiveRecord
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
        return parent::find()->andFilterWhere(['empresa_id' =>@Yii::$app->user->identity->empresa_id]);
    }

    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventarios_ajustes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['repuesto_id', 'ubicacion_inventario_id','cantidad_repuesto','concepto_id','fecha_ajuste','usuario_id'], 'required'],
            [['id', 'repuesto_id', 'ubicacion_inventario_id', 'cantidad_repuesto', 'concepto_id', 'usuario_id', 'empresa_id', 'saldo', 'creado_por', 'actualizado_por'], 'integer'],
            [['observaciones'], 'string'],
            [['fecha_ajuste', 'creado_el', 'actualizado_el'], 'safe'],
            [['id'], 'unique'],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['concepto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conceptos::className(), 'targetAttribute' => ['concepto_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['ubicacion_inventario_id'], 'exist', 'skipOnError' => true, 'targetClass' => UbicacionesInsumos::className(), 'targetAttribute' => ['ubicacion_inventario_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
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
            'repuesto_id' => 'Repuesto',
            'ubicacion_inventario_id' => 'Ubicacion Inventario',
            'cantidad_repuesto' => 'Cantidad Repuesto',
            'concepto_id' => 'Concepto',
            'observaciones' => 'Observaciones',
            'fecha_ajuste' => 'Fecha Ajuste',
            'usuario_id' => 'Usuario',
            'empresa_id' => 'Empresa',
            'saldo' => 'Saldo',
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
    public function getConcepto()
    {
        return $this->hasOne(Conceptos::className(), ['id' => 'concepto_id']);
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
    public function getUbicacionInventario()
    {
        return $this->hasOne(UbicacionesInsumos::className(), ['id' => 'ubicacion_inventario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepuesto()
    {
        return $this->hasOne(Repuestos::className(), ['id' => 'repuesto_id']);
    }
}
