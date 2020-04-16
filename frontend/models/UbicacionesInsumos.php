<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ubicaciones_insumos".
 *
 * @property string $id
 * @property string $nombre Nombre de la ubicación del insumo o taller
 * @property string $codigo_interno Codigo interno de la ubicación, es opcional
 * @property int $activo Indica si esta activo o no la ubicación, por defecto se va en true
 * @property string $observacion Observacion de la ubicación
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class UbicacionesInsumos extends \common\models\MyActiveRecord
{
    public $usuario_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ubicaciones_insumos';
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
            [['nombre', 'observacion'], 'required'],
            ['codigo_interno', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Por favor sólo ingrese números.'],
            [['activo', 'creado_por', 'actualizado_por'], 'integer'],
            [['observacion'], 'string'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre'], 'string', 'max' => 355],
            [['codigo_interno'], 'string', 'max' => 20],
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
            'codigo_interno' => 'Codigo Interno',
            'activo' => 'Activo',
            'observacion' => 'Observacion',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    public function afterFind() {
        parent::afterFind();
        $this->usuario_id = ArrayHelper::getColumn($this->ubicacionesUsuarios, 'id');

    
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventarios()
    {
        return $this->hasMany(Inventarios::className(), ['ubicacion_insumo_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacionesUsuarios()
    {
        return $this->hasMany(UbicacionesInsumosUsuarios::className(), ['ubicacion_insumo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventariosAjustes()
    {
        return $this->hasMany(InventariosAjustes::className(), ['ubicacion_inventario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepuestosInventarios()
    {
        return $this->hasMany(RepuestosInventarios::className(), ['ubicacion_inventario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTraslados()
    {
        return $this->hasMany(Traslados::className(), ['ubicacion_destino_id' => 'id']);
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
}
