<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Compras;

/**
 * ComprasSearch represents the model behind the search form of `frontend\models\Compras`.
 */
class ComprasSearch extends Compras
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'proveedor_id', 'ubicacion_id', 'numero_factura', 'numero_remision', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['fecha_hora_hoy', 'fecha_factura', 'fecha_radicado', 'fecha_remision', 'creado_el', 'actualizado_el'], 'safe'],
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
        $query = Compras::find();

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
            'proveedor_id' => $this->proveedor_id,
            'ubicacion_id' => $this->ubicacion_id,
            'fecha_hora_hoy' => $this->fecha_hora_hoy,
            'fecha_factura' => $this->fecha_factura,
            'numero_factura' => $this->numero_factura,
            'fecha_radicado' => $this->fecha_radicado,
            'fecha_remision' => $this->fecha_remision,
            'numero_remision' => $this->numero_remision,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'empresa_id' => $this->empresa_id,
        ]);

        if (!empty($this->fecha_factura)) { //you dont need the if function if yourse sure you have a not null date

            $date_explode = explode(" - ", $this->fecha_factura);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_factura', $date1, $date2]);
        }

        if (!empty($this->fecha_radicado)) { //you dont need the if function if yourse sure you have a not null date

            $date_explode = explode(" - ", $this->fecha_radicado);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_radicado', $date1, $date2]);
        }

        return $dataProvider;
    }
}
