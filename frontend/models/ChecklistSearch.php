<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Checklist;

/**
 * ChecklistSearch represents the model behind the search form of `frontend\models\Checklist`.
 */
class ChecklistSearch extends Checklist
{
    public $fecha_siguente_1, $fecha_siguente_2;
    public $fecha_checklist_2,$fecha_checklist_1;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vehiculo_id', 'tipo_checklist_id', 'consecutivo', 'medicion_actual', 'usuario_id', 'creado_por', 'actualizado_por', 'estado_checklist_id'], 'integer'],
            [['fecha_siguente', 'vehiculo_id', 'hora_medicion', 'fecha_anulado', 'observacion', 'estado','creado_el', 'actualizado_el','fecha_checklist'], 'safe'],
            [['fecha_checklist_1','fecha_checklist_2','fecha_siguente_1','fecha_siguente_2'],'safe'],
            [['medicion_siguente'], 'number'],
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
        $query = Checklist::find();

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
           // 'fecha_siguente' => $this->fecha_siguente,
           
            'hora_medicion' => $this->hora_medicion,
            'fecha_anulado' => $this->fecha_anulado,
            'medicion_siguente' => $this->medicion_siguente,
            'vehiculo_id' => $this->vehiculo_id,
            'tipo_checklist_id' => $this->tipo_checklist_id,
            'medicion_actual' => $this->medicion_actual,
            'usuario_id' => $this->usuario_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['between', 'fecha_checklist', $this->fecha_checklist_1, $this->fecha_checklist_2]);
        $query->andFilterWhere(['between', 'fecha_siguente', $this->fecha_siguente_1, $this->fecha_siguente_2]);
        

        $query->andFilterWhere(['like', 'observacion', $this->observacion]);
        $query->andFilterWhere(['like', 'estado', $this->estado]);

         if (!empty($this->fecha_checklist)) { //you dont need the if function if yourse sure you have a not null date
            $date_explode = explode(" - ", $this->fecha_checklist);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_checklist', $date1, $date2]);
        }
        if (!empty($this->fecha_siguiente)) { //you dont need the if function if yourse sure you have a not null date
            $date_explode = explode(" - ", $this->fecha_siguiente);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_siguiente', $date1, $date2]);
        }
        if (!empty($this->fecha_anulado)) { //you dont need the if function if yourse sure you have a not null date
            $date_explode = explode(" - ", $this->fecha_anulado);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_anulado', $date1, $date2]);
        }
        return $dataProvider;
    }
}
