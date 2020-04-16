<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\VehiculosSegurosArchivos;

/**
 * VehiculosSegurosArchivosSearch represents the model behind the search form of `frontend\models\VehiculosSegurosArchivos`.
 */
class VehiculosSegurosArchivosSearch extends VehiculosSegurosArchivos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vehiculo_id', 'tipo_seguro_id', 'creado_por', 'actualizado_por', 'empresa_id', 'es_actual'], 'integer'],
            [['nombre_archivo_original', 'nombre_archivo', 'ruta_archivo', 'creado_el', 'actualizado_el'], 'safe'],
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
     * Búsqueda seguros por vehiculo
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchSegurosVehiculo($params){

        $query = VehiculosSegurosArchivos::find();

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'vehiculo_id' => $this->vehiculo_id,
        ]);

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
        if(!empty($params))
        {
            $query = VehiculosSegurosArchivos::find()->where(['vehiculo_id'=>$_GET['idv']])->andWhere(['tipo_seguro_id'=>$_GET['idSeguro']]);
        }else{
            $query = VehiculosSegurosArchivos::find();
        }

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
            'tipo_seguro_id' => $this->tipo_seguro_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'empresa_id' => $this->empresa_id,
            'es_actual' => $this->es_actual,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo_original', $this->nombre_archivo_original])
            ->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'ruta_archivo', $this->ruta_archivo]);

        return $dataProvider;
    }
}
