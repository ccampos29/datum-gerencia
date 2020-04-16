<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "acuerdo_precios".
 *
 * @property string $id
 * @property string $nombre Nombre para el grupo de novedades
 * @property string $aplica_para Aplica para Trabajos o Insumos
 * @property string $fecha_inicial
 * @property string $fecha_final
 * @property int $estado
 * @property string $comentario Comentario para el grupo de novedades
 * @property string $empresa_id
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 */
class AcuerdoPrecios extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acuerdo_precios';
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
            [['nombre', 'fecha_inicial', 'fecha_final', 'estado', 'comentario','proveedor_id'], 'required'],
            [['aplica_para', 'comentario'], 'string'],
            [['fecha_inicial', 'fecha_final', 'creado_el', 'actualizado_el'], 'safe'],
            [['estado', 'empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            ['fecha_inicial', 'compare', 'compareAttribute'=>'fecha_final', 'operator'=>'<'],
            ['fecha_final', 'compare', 'compareAttribute'=>'fecha_inicial', 'operator'=>'>'],
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
            'aplica_para' => 'Aplica Para',
            'fecha_inicial' => 'Fecha Inicial',
            'fecha_final' => 'Fecha Final',
            'estado' => 'Estado',
            'comentario' => 'Comentario',
            'empresa_id' => 'Empresa ID',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'proveedor_id'=>'Proveedor'
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
}
