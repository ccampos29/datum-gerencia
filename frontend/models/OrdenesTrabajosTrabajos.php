<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "ordenes_trabajos_trabajos".
 *
 * @property int $id
 * @property int $orden_trabajo_id Es el dato intermedio de orden de trabajo
 * @property int $trabajo_id Es el dato intermedio del trabajo
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property OrdenesTrabajos $ordenTrabajo
 * @property Trabajos $trabajo
 */
class OrdenesTrabajosTrabajos extends MyActiveRecord
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
        return 'ordenes_trabajos_trabajos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orden_trabajo_id', 'trabajo_id', 'orden_trabajo_id', 'tipo_mantenimiento_id', 'costo_mano_obra', 'cantidad'], 'required'],
            [['orden_trabajo_id', 'trabajo_id', 'tipo_mantenimiento_id', 'costo_mano_obra', 'cantidad', 'empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['orden_trabajo_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenesTrabajos::className(), 'targetAttribute' => ['orden_trabajo_id' => 'id']],
            [['trabajo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajos::className(), 'targetAttribute' => ['trabajo_id' => 'id']],
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
            'orden_trabajo_id' => 'Orden Trabajo',
            'trabajo_id' => 'Trabajo',
            'tipo_mantenimiento_id' => 'Tipo Mantenimiento',
            'costo_mano_obra' => 'Costo Mano Obra',
            'cantidad' => 'Cantidad',
            'empresa_id' => 'Empresa ID',
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
    public function getOrdenTrabajo()
    {
        return $this->hasOne(OrdenesTrabajos::className(), ['id' => 'orden_trabajo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajo()
    {
        return $this->hasOne(Trabajos::className(), ['id' => 'trabajo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoMantenimiento()
    {
        return $this->hasOne(TiposMantenimientos::className(), ['id' => 'tipo_mantenimiento_id']);
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
     * Suma el valor del trabajo a la orden
     * @param array $idOrden, $valor
     */
    public function sumarValorOrdenTrabajo($idOrden, $valor, $cantidad) {
        $orden = OrdenesTrabajos::findOne($idOrden);
        $orden->total_valor_trabajo = $orden->total_valor_trabajo + ($valor * $cantidad);
        $orden->save();
    }

    /**
     * Resta el valor del trabajo a la orden
     * @param array $idOrden, $valor
     */
    public function restarValorOrdenTrabajo($idOrden, $valor, $cantidad) {
        $orden = OrdenesTrabajos::findOne($idOrden);
        $orden->total_valor_trabajo = $orden->total_valor_trabajo - ($valor * $cantidad);
        $orden->save();
    }

    /**
     * Actualiza el valor del trabajo a la orden
     * @param array $idOrden, $valor, $valorViejo
     */
    public function actualizarValorOrdenTrabajo($idOrden, $valor, $valorViejo, $cantidad) {
        $orden = OrdenesTrabajos::findOne($idOrden);
        $orden->total_valor_trabajo = $orden->total_valor_trabajo - ($valor * $cantidad);
        $orden->total_valor_trabajo = $orden->total_valor_trabajo + ($valor * $cantidad);
        $orden->save();
    }
}
