<?php

namespace frontend\models;
use common\models\User;
use Yii;

/**
 * This is the model class for table "clientes_sucursales".
 *
 * @property int $id
 * @property string $nombre Nombre para el grupo de novedades
 * @property int $codigo Codigo de identificacion unico del cliente
 * @property string $direccion Direccion de la sucursal del cliente
 * @property int $telefono_fijo Numero de telefono fijo del cliente
 * @property int $telefono_movil Numero de celular del cliente
 * @property string $contacto Comentario para el grupo de novedades
 * @property int $pais_id Relación con paises
 * @property int $departamento_id Relación con departamentos
 * @property int $municipio_id Relación con municipios
 * @property int $activo Estado de la sucursal del cliente
 * @property string $email E-mail del cliente
 * @property string $observacion Observacion del cliente
 * @property int $cliente_id Relación con clientes
 * @property int $empresa_id Relación con empresas
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property Clientes $cliente
 * @property User $creadoPor
 * @property Departamentos $departamento
 * @property Empresas $empresa
 * @property Municipios $municipio
 * @property Pais $pais
 */
class ClientesSucursales extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clientes_sucursales';
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
            [['nombre', 'codigo', 'direccion', 'telefono_fijo', 'telefono_movil', 'contacto', 'pais_id', 'departamento_id', 'municipio_id', 'activo', 'email', 'observacion', 'cliente_id'], 'required'],
            [['codigo', 'telefono_fijo', 'telefono_movil', 'pais_id', 'departamento_id', 'municipio_id', 'activo', 'cliente_id', 'empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['contacto', 'observacion'], 'string'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['email'],'email'],
            [['nombre', 'direccion', 'email'], 'string', 'max' => 255],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['cliente_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamentos::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['municipio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Municipios::className(), 'targetAttribute' => ['municipio_id' => 'id']],
            [['pais_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['pais_id' => 'id']],
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
            'direccion' => 'Direccion',
            'telefono_fijo' => 'Telefono Fijo',
            'telefono_movil' => 'Telefono Movil',
            'contacto' => 'Contacto',
            'pais_id' => 'Pais ID',
            'departamento_id' => 'Departamento ID',
            'municipio_id' => 'Municipio ID',
            'activo' => 'Activo',
            'email' => 'Email',
            'observacion' => 'Observacion',
            'cliente_id' => 'Cliente ID',
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
    public function getActualizadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Clientes::className(), ['id' => 'cliente_id']);
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
    public function getDepartamento()
    {
        return $this->hasOne(Departamentos::className(), ['id' => 'departamento_id']);
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
    public function getMunicipio()
    {
        return $this->hasOne(Municipios::className(), ['id' => 'municipio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'pais_id']);
    }
}
