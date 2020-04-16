<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\EstadosChecklistConfiguracion;

/**
 * EstadosChecklistConfiguracionSearch represents the model behind the search form of `\frontend\models\EstadosChecklistConfiguracion`.
 */
class EstadosChecklistConfiguracionSearch extends EstadosChecklistConfiguracion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipo_checklist_id', 'estado_checklist_id', 'porcentaje_maximo_rej', 'cantidad_maxima_crit', 'empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['descripcion', 'creado_el', 'actualizado_el'], 'safe'],
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
        $query = EstadosChecklistConfiguracion::find();

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
            'tipo_checklist_id' => $this->tipo_checklist_id,
            'estado_checklist_id' => $this->estado_checklist_id,
            'porcentaje_maximo_rej' => $this->porcentaje_maximo_rej,
            'cantidad_maxima_crit' => $this->cantidad_maxima_crit,
            'empresa_id' => $this->empresa_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
