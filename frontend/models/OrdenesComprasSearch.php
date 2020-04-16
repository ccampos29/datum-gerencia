<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\OrdenesCompras;

/**
 * OrdenesComprasSearch represents the model behind the search form of `frontend\models\OrdenesCompras`.
 */
class OrdenesComprasSearch extends OrdenesCompras
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'consecutivo', 'proveedor_id', 'proviene_de', 'estado', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['fecha_hora_orden', 'forma_pago', 'direccion', 'observacion', 'creado_el', 'actualizado_el'], 'safe'],
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
        $query = OrdenesCompras::find();

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
            'fecha_hora_orden' => $this->fecha_hora_orden,
            'proveedor_id' => $this->proveedor_id,
            'estado' => $this->estado,
            'proviene_de' => $this->proviene_de,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'empresa_id' => $this->empresa_id,
        ]);

        $query->andFilterWhere(['like', 'forma_pago', $this->forma_pago])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'observacion', $this->observacion]);

        if (!empty($this->fecha_hora_orden)) { //you dont need the if function if yourse sure you have a not null date

            $date_explode = explode(" - ", $this->fecha_hora_orden);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_hora_orden', $date1, $date2]);
        }

        return $dataProvider;
    }
}
