<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "repuestos_inventariables".
 *
 * @property int $id
 * @property int $repuesto_id Dato intermedio de los repuestos
 * @property int $ubicacion_id Dato intermedio de las ubicaciones
 * @property int $cantidad Es la cantidad de un repuesto
 * @property int $valor_unitario Es el valor de un repuesto
 * @property int $cantidad_minima Es la cantidad de un repuesto
 * @property int $cantidad_maxima Es la cantidad de un repuesto
 * @property int $estado Determina si el repuesto esta Activo o Inactivo en la ubiacion
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relacion con Empresa
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Empresas $empresa
 * @property Repuestos $repuesto
 * @property UbicacionesInsumos $ubicacion
 */
class RepuestosInventariables extends MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'repuestos_inventariables';
    }

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
        return parent::find()->andFilterWhere(['empresa_id' => @Yii::$app->user->identity->empresa_id]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ubicacion_id', 'cantidad', 'valor_unitario', 'cantidad_minima', 'cantidad_maxima'], 'required'],
            [['repuesto_id', 'ubicacion_id', 'cantidad', 'valor_unitario', 'cantidad_minima', 'cantidad_maxima', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['repuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repuestos::className(), 'targetAttribute' => ['repuesto_id' => 'id']],
            [['ubicacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => UbicacionesInsumos::className(), 'targetAttribute' => ['ubicacion_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
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
            'ubicacion_id' => 'Ubicacion',
            'cantidad' => 'Cantidad',
            'valor_unitario' => 'Valor Unitario',
            'cantidad_minima' => 'Cantidad Minima',
            'cantidad_maxima' => 'Cantidad Maxima',
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
    public function getRepuesto()
    {
        return $this->hasOne(Repuestos::className(), ['id' => 'repuesto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacion()
    {
        return $this->hasOne(UbicacionesInsumos::className(), ['id' => 'ubicacion_id']);
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


    public function sumarCompra($idCompra)
    {
        $compras = ComprasRepuestos::find()->where(['compra_id' => $idCompra])->all();
        if ($compras != null) {
            foreach ($compras as $compra) {
                $repuesto = RepuestosInventariables::findOne(['repuesto_id' => $compra->repuesto_id]);
                if ($repuesto != null) {
                    $repuesto->cantidad = $repuesto->cantidad + $compra->cantidad;
                    $repuesto->save();
                }
                else {
                    $inventariable = new RepuestosInventariables();
                    $inventariable->repuesto_id = $compra->repuesto_id;
                    $inventariable->ubicacion_id = $compra->compra->ubicacion_id;
                    $inventariable->cantidad = $compra->cantidad;
                    $inventariable->valor_unitario = $compra->valor_unitario;
                    $inventariable->cantidad_minima = 1;
                    $inventariable->cantidad_maxima = $compra->cantidad;
                    $inventariable->save();
                    if(!$inventariable->save()){
                        print_r($inventariable->getErrors());
                        die();
                    }
                }
            }
        }
    }
}
