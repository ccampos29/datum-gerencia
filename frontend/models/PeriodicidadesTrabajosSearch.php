<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PeriodicidadesTrabajos;

/**
 * PeriodicidadesTrabajosSearch represents the model behind the search form of `frontend\models\PeriodicidadesTrabajos`.
 */
class PeriodicidadesTrabajosSearch extends PeriodicidadesTrabajos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vehiculo_id', 'trabajo_id', 'tipo_periodicidad', 'creado_por', 'actualizado_por'], 'integer'],
            [['unidad_periodicidad', 'trabajo_normal', 'trabajo_bajo', 'trabajo_severo', 'creado_el', 'actualizado_el'], 'safe'],
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
    public function search($params, $idTrabajo)
    {
        $query = PeriodicidadesTrabajos::find()->where(['trabajo_id' => $idTrabajo]);

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
            'vehiculo_id' => $this->vehiculo_id,
            'trabajo_id' => $this->trabajo_id,
            'tipo_periodicidad' => $this->tipo_periodicidad,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'unidad_periodicidad', $this->unidad_periodicidad])
            ->andFilterWhere(['like', 'trabajo_normal', $this->trabajo_normal])
            ->andFilterWhere(['like', 'trabajo_bajo', $this->trabajo_bajo])
            ->andFilterWhere(['like', 'trabajo_severo', $this->trabajo_severo]);

        return $dataProvider;
    }
}
