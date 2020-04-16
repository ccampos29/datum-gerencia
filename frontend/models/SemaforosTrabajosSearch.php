<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\SemaforosTrabajos;

/**
 * SemaforosTrabajosSearch represents the model behind the search form of `\frontend\models\SemaforosTrabajos`.
 */
class SemaforosTrabajosSearch extends SemaforosTrabajos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'desde', 'hasta', 'empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['indicador', 'creado_el', 'actualizado_el'], 'safe'],
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
        $query = SemaforosTrabajos::find();

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
            'desde' => $this->desde,
            'hasta' => $this->hasta,
            'empresa_id' => $this->empresa_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'indicador', $this->indicador]);

        return $dataProvider;
    }
}
