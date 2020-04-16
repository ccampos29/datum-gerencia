<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;
use common\models\User;

/**
 * This is the model class for table "informacion_adicional_usuarios".
 *
 * @property int $id
 * @property string $direccion Dirección del usuario
 * @property int $pais_id Pais del usuario
 * @property int $departamento_id Departamento del usuario
 * @property int $municipio_id Municipio del usuario
 * @property string $numero_movil Número de celular del usuario
 * @property string $numero_fijo_extension Número fijo y extensión del usuario
 * @property int $numero_cuenta_bancaria Número de la cuenta bancaria del usuario
 * @property string $tipo_cuenta_bancaria Tipo de la cuenta bancaria
 * @property string $nombre_banco Nombre del banco en que se tiene la cuenta bancaria
 * @property int $usuario_id
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $usuario
 * @property Pais $pais
 * @property Departamentos $departamento
 * @property Municipios $municipio
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class InformacionAdicionalUsuarios extends MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'informacion_adicional_usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pais_id', 'departamento_id', 'municipio_id', 'numero_cuenta_bancaria', 'usuario_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['tipo_cuenta_bancaria'], 'string'],
            //[['usuario_id', 'creado_por', 'creado_el', 'actualizado_por', 'actualizado_el'], 'required'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['direccion'], 'string', 'max' => 255],
            [['numero_movil'], 'string', 'max' => 12],
            [['numero_fijo_extension'], 'string', 'max' => 20],
            [['nombre_banco'], 'string', 'max' => 500],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['pais_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['pais_id' => 'id']],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamentos::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['municipio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Municipios::className(), 'targetAttribute' => ['municipio_id' => 'id']],
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
            'direccion' => 'Dirección',
            'pais_id' => 'Pais',
            'departamento_id' => 'Departamento',
            'municipio_id' => 'Municipio',
            'numero_movil' => 'Número movil',
            'numero_fijo_extension' => 'Número fijo y extensión',
            'numero_cuenta_bancaria' => 'Número cuenta bancaria',
            'tipo_cuenta_bancaria' => 'Tipo de cuenta bancaria',
            'nombre_banco' => 'Nombre del banco',
            'usuario_id' => 'Usuario',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
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
    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'pais_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamento()
    {
        return $this->hasOne(Departamentos::className(), ['id' => 'departamento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipio()
    {
        return $this->hasOne(Municipios::className(), ['id' => 'municipio_id']);
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
