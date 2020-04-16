<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\InformacionAdicionalUsuarios;

/**
 * InformacionAdicionalUsuariosSearch represents the model behind the search form of `frontend\models\InformacionAdicionalUsuarios`.
 */
class InformacionAdicionalUsuariosSearch extends InformacionAdicionalUsuarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pais_id', 'departamento_id', 'municipio_id', 'numero_cuenta_bancaria', 'usuario_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['direccion', 'numero_movil', 'numero_fijo_extension', 'tipo_cuenta_bancaria', 'nombre_banco', 'creado_el', 'actualizado_el'], 'safe'],
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
        $query = InformacionAdicionalUsuarios::find();

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
            'pais_id' => $this->pais_id,
            'departamento_id' => $this->departamento_id,
            'municipio_id' => $this->municipio_id,
            'numero_cuenta_bancaria' => $this->numero_cuenta_bancaria,
            'usuario_id' => $this->usuario_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'numero_movil', $this->numero_movil])
            ->andFilterWhere(['like', 'numero_fijo_extension', $this->numero_fijo_extension])
            ->andFilterWhere(['like', 'tipo_cuenta_bancaria', $this->tipo_cuenta_bancaria])
            ->andFilterWhere(['like', 'nombre_banco', $this->nombre_banco]);

        return $dataProvider;
    }
}
