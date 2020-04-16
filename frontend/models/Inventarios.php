<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "inventarios".
 *
 * @property int $id
 * @property string $fecha_inventario Es la fecha de cuando se hizo el inventario
 * @property string $hora_inventario Es la hora de cuando se hizo el inventario
 * @property int $estado Determina si el inventario esta abierto o cerrado
 * @property int $ubicacion_insumo_id Es la ubicacion de donde se esta haciendo el inventario
 * @property string $observacion Es una observacion sobre el inventario
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relacion con Empresa
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property UbicacionesInsumos $ubicacionInsumo
 * @property Empresas $empresa
 * @property InventariosRepuestos[] $inventariosRepuestos
 */
class Inventarios extends MyActiveRecord
{

    public $repuestos;

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
        return 'inventarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_hora_inventario'], 'required'],
            [['fecha_hora_inventario', 'creado_el', 'actualizado_el'], 'safe'],
            [['ubicacion_insumo_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['observacion'], 'string', 'max' => 355],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['ubicacion_insumo_id'], 'exist', 'skipOnError' => true, 'targetClass' => UbicacionesInsumos::className(), 'targetAttribute' => ['ubicacion_insumo_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [
                'repuestos',
                'validarRepuestos'
            ],
            [
                'repuestos',
                'repuestoRepetido'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_hora_inventario' => 'Fecha y Hora Inventario',
            'ubicacion_insumo_id' => 'Ubicacion Insumo',
            'observacion' => 'Observacion',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
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
    public function getUbicacionInsumo()
    {
        return $this->hasOne(UbicacionesInsumos::className(), ['id' => 'ubicacion_insumo_id']);
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
    public function getInventariosRepuestos()
    {
        return $this->hasMany(InventariosRepuestos::className(), ['inventario_id' => 'id']);
    }


    /**
     * Asocia los repuestos al inventario
     * @param array $repuestos
     */
    public function asociarRepuestos($repuestos)
    {
        $this->eliminarRepuestos($this->id);
        foreach ($repuestos as $repuesto) {
            $inventarioRepuesto = new InventariosRepuestos();
            $inventarioRepuesto->inventario_id = $this->id;
            $inventarioRepuesto->repuesto_id  = $repuesto['repuesto_id'];
            $inventarioRepuesto->cantidad_fisica = $repuesto['cantidad_fisica'];
            $inventarioRepuesto->unidad_medida_id = $repuesto['unidad_medida_id'];
            $inventarioRepuesto->observacion = $repuesto['observacion'];
            if (!$inventarioRepuesto->save()) {
                print_r($inventarioRepuesto->getErrors());
                die();
            }
        }
    }

    /**
     * Elimina los repuestos al inventario
     * @param array $id
     */
    public function eliminarRepuestos($id)
    {
        $model = Inventarios::findOne($id);
        $repuestos = $model->inventariosRepuestos;

        foreach ($repuestos as $repuesto) {
            $repuesto->delete();
        }
    }

    public function antesDelete()
    {
        $model = Inventarios::findOne($this->id);
        $repuestos = $model->inventariosRepuestos;

        foreach ($repuestos as $repuesto) {
            $repuesto->delete();
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->repuestos = $this->inventariosRepuestos;
    }

    public function validarRepuestos()
    {
        foreach ($this->repuestos as $indexRepuesto => $repuesto) {
            if (empty($repuesto['repuesto_id'])) {
                $error = '"Repuesto" no puede estar vacio.';
                $this->addError('repuestos[' . $indexRepuesto . '][repuesto_id]', $error);
            }
            if (empty($repuesto['cantidad_fisica'])) {
                $error = '"Cantidad" no puede estar vacio.';
                $this->addError('repuestos[' . $indexRepuesto . '][cantidad_fisica]', $error);
            }
            if (empty($repuesto['unidad_medida_id'])) {
                $error = 'Unidad de medida no puede estar vacio.';
                $this->addError('repuestos[' . $indexRepuesto . '][unidad_medida_id]', $error);
            }
            if (empty($repuesto['observacion'])) {
                $error = 'La observación no puede ir vacia.';
                $this->addError('repuestos[' . $indexRepuesto . '][observacion]', $error);
            }
        }
    }

    public function repuestoRepetido()
    {
        for ($i = 0; $i < count($this->repuestos); $i++) {
            for ($j = 0; $j < count($this->repuestos); $j++) {
                if($this->repuestos[$i]['repuesto_id'] == $this->repuestos[$j]['repuesto_id'] && $i !== $j){
                    $error = '"Repuesto" no puede estar repetido';
                    $this->addError('repuestos[' . $j . '][repuesto_id]', $error);
                }
            }
        }
    }
}
