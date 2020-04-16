<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "tipos_seguros".
 *
 * @property string $id
 * @property string $nombre Nombre del tipo de seguro
 * @property string $codigo Codigo para el tipo de seguro
 * @property string $descripcion Descripción del tipo de seguro
 * @property int $dias_alerta Dias para alertar antes de que deje de cubir el seguro
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class TiposSeguros extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipos_seguros';
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
            /* ['nombre', 'match', 'pattern' => '/^[A-Za-z]+$/', 'message' => 'Por favor sólo ingrese letras, y sin espacios en blanco.'], */
            [['descripcion'], 'string'],
            [['dias_alerta', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre'], 'string', 'max' => 355],
            [['codigo'], 'string', 'max' => 20],
            [['codigo'], 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Por favor sólo ingrese números.'],
            ['dias_alerta','integer','min' => 0],
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
