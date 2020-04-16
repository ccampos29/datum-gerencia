<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\RepuestosProveedores;

/**
 * RepuestosProveedoresSearch represents the model behind the search form of `frontend\models\RepuestosProveedores`.
 */
class RepuestosProveedoresSearch extends RepuestosProveedores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'repuesto_id', 'proveedor_id', 'valor', 'impuesto_id', 'descuento_repuesto', 'plazo_pago', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['tipo_descuento', 'codigo', 'creado_el', 'actualizado_el'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Búsqueda repuestos por proveedor
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchRepuestosProveedor($params){

        $query = RepuestosProveedores::find();

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'proveedor_id' => $this->proveedor_id,
        ]);

        return $dataProvider;
    }

    /**
     * Implementación DataProvider
     * @return ActiveDataProvider
     */
    public function callingDataProvider($query,$params){
        $dataProvider =  new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $idRepuesto)
    {
        $query = RepuestosProveedores::find()->where(['repuesto_id' => $idRepuesto]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'repuesto_id' => $this->repuesto_id,
            'proveedor_id' => $this->proveedor_id,
            'valor' => $this->valor,
            'impuesto_id' => $this->impuesto_id,
            'descuento_repuesto' => $this->descuento_repuesto,
            'plazo_pago' => $this->plazo_pago,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'empresa_id' => $this->empresa_id,
        ]);

        $query->andFilterWhere(['like', 'tipo_descuento', $this->tipo_descuento])
            ->andFilterWhere(['like', 'codigo', $this->codigo]);

        return $dataProvider;
    }
}
