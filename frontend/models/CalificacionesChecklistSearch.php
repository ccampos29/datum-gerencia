<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\CalificacionesChecklist;

/**
 * CalificacionesChecklistSearch represents the model behind the search form of `frontend\models\CalificacionesChecklist`.
 */
class CalificacionesChecklistSearch extends CalificacionesChecklist
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'novedad_id', 'grupo_novedad_id', 'checklist_id', 'tipo_checklist_id', 'vehiculo_id', 'criterio_calificacion_id', 'creado_por', 'actualizado_por', 'empresa_id','valor_texto_editable'], 'integer'],
            [['valor_texto_calificacion', 'creado_el', 'actualizado_el'], 'safe'],
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
        $query = CalificacionesChecklist::find();

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
            'novedad_id' => $this->novedad_id,
            'grupo_novedad_id' => $this->grupo_novedad_id,
            'checklist_id' => $this->checklist_id,
            'tipo_checklist_id' => $this->tipo_checklist_id,
            'vehiculo_id' => $this->vehiculo_id,
            'criterio_calificacion_id' => $this->criterio_calificacion_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'empresa_id' => $this->empresa_id,
        ]);

        $query->andFilterWhere(['like', 'valor_texto_calificacion', $this->valor_texto_calificacion]);
        $query->andFilterWhere(['like', 'valor_texto_editable', $this->valor_texto_editable]);

        return $dataProvider;
    }
}
