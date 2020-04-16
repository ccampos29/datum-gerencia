<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\NovedadesMantenimientos;

/**
 * NovedadesMantenimientosSearch represents the model behind the search form of `frontend\models\NovedadesMantenimientos`.
 */
class NovedadesMantenimientosSearch extends NovedadesMantenimientos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vehiculo_id', 'usuario_reporte_id', 'orden_trabajo_id', 'checklist_id', 'prioridad_id', 'medicion', 'usuario_responsable_id', 'trabajo_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['fecha_hora_reporte', 'observacion', 'fecha_solucion', 'estado', 'proviene_de', 'creado_el', 'actualizado_el'], 'safe'],
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
     * Búsqueda novedades por orden
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchNovedadesOrden($params, $idOrden){

        $query = NovedadesMantenimientos::find()->where(['orden_trabajo_id' => $idOrden]);

        $dataProvider = $this->callingDataProvider($query,$params);


        return $dataProvider;
    }

    /**
     * Implementación DataProvider
     * @return ActiveDataProvider
     */
    public function callingDataProvider($query,$params){
        $dataProvider =  new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
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
        $query = NovedadesMantenimientos::find()->orderBy(['id'=> SORT_DESC]);

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
            'fecha_hora_reporte' => $this->fecha_hora_reporte,
            'usuario_reporte_id' => $this->usuario_reporte_id,
            'prioridad_id' => $this->prioridad_id,
            'medicion' => $this->medicion,
            'usuario_responsable_id' => $this->usuario_responsable_id,
            'trabajo_id' => $this->trabajo_id,
            'fecha_solucion' => $this->fecha_solucion,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'checklist_id' => $this->checklist_id,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'estado', $this->estado]);


        if (!empty($this->fecha_hora_reporte)) { //you dont need the if function if yourse sure you have a not null date
        
            $date_explode = explode(" - ", $this->fecha_hora_reporte);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_hora_reporte', $date1, $date2]);
        }


        return $dataProvider;
    }
}
