<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ClientesSucursales;

/**
 * ClientesSucursalesSearch represents the model behind the search form of `frontend\models\ClientesSucursales`.
 */
class ClientesSucursalesSearch extends ClientesSucursales
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'codigo', 'telefono_fijo', 'telefono_movil', 'pais_id', 'departamento_id', 'municipio_id', 'activo', 'cliente_id', 'empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['nombre', 'direccion', 'contacto', 'email', 'observacion', 'creado_el', 'actualizado_el'], 'safe'],
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
        $query = ClientesSucursales::find();

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
            'codigo' => $this->codigo,
            'telefono_fijo' => $this->telefono_fijo,
            'telefono_movil' => $this->telefono_movil,
            'pais_id' => $this->pais_id,
            'departamento_id' => $this->departamento_id,
            'municipio_id' => $this->municipio_id,
            'activo' => $this->activo,
            'cliente_id' => $this->cliente_id,
            'empresa_id' => $this->empresa_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'contacto', $this->contacto])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'observacion', $this->observacion]);

        return $dataProvider;
    }
}
