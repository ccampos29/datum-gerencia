<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Solicitudes;

/**
 * SolicitudesSearch represents the model behind the search form of `frontend\models\Solicitudes`.
 */
class SolicitudesSearch extends Solicitudes
{
    public $fecha_inicio_solicitud;
    public $fecha_fin_solicitud;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vehiculo_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['fecha_hora_solicitud', 'tipo', 'estado', 'creado_el', 'actualizado_el','fecha_inicio_solicitud','fecha_fin_solicitud'], 'safe'],
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
        $query = Solicitudes::find();

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
            'fecha_hora_solicitud' => $this->fecha_hora_solicitud,
            'vehiculo_id' => $this->vehiculo_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'empresa_id' => $this->empresa_id,
        ]);

        $query->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        if (!empty($this->fecha_hora_solicitud)) { //you dont need the if function if yourse sure you have a not null date

            $date_explode = explode(" - ", $this->fecha_hora_solicitud);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_hora_solicitud', $date1, $date2]);
        }

        if (!empty($this->fecha_inicio_solicitud) && !empty($this->fecha_fin_solicitud)) { //you dont need the if function if yourse sure you have a not null date
            $query->andFilterWhere(['between', 'fecha_hora_solicitud', $this->fecha_inicio_solicitud, $this->fecha_fin_solicitud]);
        }

        return $dataProvider;
    }
}
