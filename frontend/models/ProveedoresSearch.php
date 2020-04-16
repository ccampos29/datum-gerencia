<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Proveedores;

/**
 * ProveedorSearch represents the model behind the search form of `\frontend\models\Proveedor`.
 */
class ProveedoresSearch extends Proveedores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipo_proveedor_id', 'pais_id', 'departamento_id', 'municipio_id', 'activo', 'creado_por', 'actualizado_por'], 'integer'],
            [['nombre', 'identificacion', 'digito_verificacion', 'telefono_fijo_celular', 'email', 'direccion', 'nombre_contacto', 'regimen', 'tipo_procedencia', 'creado_el', 'actualizado_el'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Proveedores::find();

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
            'tipo_proveedor_id' => $this->tipo_proveedor_id,
            'pais_id' => $this->pais_id,
            'departamento_id' => $this->departamento_id,
            'municipio_id' => $this->municipio_id,
            'activo' => $this->activo,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'identificacion', $this->identificacion])
            ->andFilterWhere(['like', 'digito_verificacion', $this->digito_verificacion])
            ->andFilterWhere(['like', 'telefono_fijo_celular', $this->telefono_fijo_celular])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'nombre_contacto', $this->nombre_contacto])
            ->andFilterWhere(['like', 'regimen', $this->regimen])
            ->andFilterWhere(['like', 'tipo_procedencia', $this->tipo_procedencia]);

        return $dataProvider;
    }
}
