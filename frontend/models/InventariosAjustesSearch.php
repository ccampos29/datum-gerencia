<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\InventariosAjustes;

/**
 * InventariosAjustesSearch represents the model behind the search form of `frontend\models\InventariosAjustes`.
 */
class InventariosAjustesSearch extends InventariosAjustes
{
    public $fecha_inicio_ajuste;
    public $fecha_fin_ajuste;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'repuesto_id', 'ubicacion_inventario_id', 'cantidad_repuesto', 'concepto_id', 'usuario_id', 'empresa_id', 'saldo', 'creado_por', 'actualizado_por'], 'integer'],
            [['observaciones', 'fecha_ajuste', 'creado_el', 'actualizado_el','fecha_inicio_ajuste','fecha_fin_ajuste'], 'safe'],
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
        $query = InventariosAjustes::find();

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
            'repuesto_id' => $this->repuesto_id,
            'ubicacion_inventario_id' => $this->ubicacion_inventario_id,
            'cantidad_repuesto' => $this->cantidad_repuesto,
            'concepto_id' => $this->concepto_id,
            'fecha_ajuste' => $this->fecha_ajuste,
            'usuario_id' => $this->usuario_id,
            'empresa_id' => $this->empresa_id,
            'saldo' => $this->saldo,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'observaciones', $this->observaciones]);

        if (!empty($this->fecha_ajuste)) { //you dont need the if function if yourse sure you have a not null date

            $date_explode = explode(" - ", $this->fecha_ajuste);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_ajuste', $date1, $date2]);
        }

        if (!empty($this->fecha_inicio_ajuste) && !empty($this->fecha_fin_ajuste)) { //you dont need the if function if yourse sure you have a not null date
            $query->andFilterWhere(['between', 'fecha_ajuste', $this->fecha_inicio_ajuste, $this->fecha_fin_ajuste]);
        }

        return $dataProvider;
    }
}
