<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Combustibles;

/**
 * CombustiblesSearch represents the model behind the search form of `frontend\models\Combustibles`.
 */
class CombustiblesSearch extends Combustibles
{
    public $total_cost;
    public $total_cant;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tanqueo_full', 'cantidad_combustible', 'vehiculo_id', 'tipo_combustible_id', 'proveedor_id', 'usuario_id', 'centro_costo_id', 'municipio_id', 'departamento_id', 'pais_id', 'medicion_actual', 'grupo_vehiculo_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['fecha_1','fecha_2', 'fecha', 'hora', 'observacion', 'numero_tiquete', 'creado_el', 'actualizado_el'], 'safe'],
            [['costo_por_galon'], 'number'],
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
    public function searchCombustibleCosto($params){
        $query = Combustibles::find()->select([' (sum(costo_por_galon* cantidad_combustible)) as total_cost','sum(cantidad_combustible) as total_cant',  'combustibles.*']);
        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'tipo_combustible_id' => $this->tipo_combustible_id,
            'proveedor_id' => $this->proveedor_id,
        ]);

        $query->andFilterWhere(['between', 'fecha', $this->fecha_1, $this->fecha_2]);

        return $dataProvider;
    }



    /**
     * Búsqueda combustible por proveedor
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchCombustibleProveedor($params){
        $query = Combustibles::find()->select([' (sum(costo_por_galon* cantidad_combustible)) as total_cost','sum(cantidad_combustible) as total_cant',  'combustibles.*'])->groupBy(['proveedor_id']);
        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'tipo_combustible_id' => $this->tipo_combustible_id,
            'proveedor_id' => $this->proveedor_id,
        ]);

        $query->andFilterWhere(['between', 'fecha', $this->fecha_1, $this->fecha_2]);

        return $dataProvider;
    }

    /**
     * Búsqueda combustible por centros de costos
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchCombustibleCentroCostos($params){
        $query = Combustibles::find()->select([' (sum(costo_por_galon* cantidad_combustible)) as total_cost','sum(cantidad_combustible) as total_cant','@recorrido := SUM(combustibles.medicion_actual- COALESCE((SELECT d.medicion_actual FROM combustibles d WHERE d.vehiculo_id = combustibles.vehiculo_id AND d.fecha = (SELECT MAX(fecha) FROM combustibles c WHERE c.vehiculo_id = combustibles.vehiculo_id AND fecha < combustibles.fecha) LIMIT 1),CAST(medicion_actual AS SIGNED) ))  AS kms_recorrido',  'combustibles.*'])->groupBy(['centro_costo_id']);

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'centro_costo_id' => $this->centro_costo_id,
        ]);

        $query->andFilterWhere(['between', 'fecha', $this->fecha_1, $this->fecha_2]);

        return $dataProvider;
    }
    /**
     * Búsqueda combustible por centros de costos
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchCombustibleVehiculoProveedor($params){
        $query = Combustibles::find()->select([' (sum(costo_por_galon* cantidad_combustible)) as total_cost','sum(cantidad_combustible) as total_cant',  'combustibles.*'])->groupBy(['vehiculo_id','proveedor_id']);
        
        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'proveedor_id' => $this->proveedor_id,
            'vehiculo_id' => $this->vehiculo_id,
        ]);

        $query->andFilterWhere(['between', 'fecha', $this->fecha_1, $this->fecha_2]);

        return $dataProvider;
    }


    public function searchCombustibleDetalleProveedor($params){
        $query = Combustibles::find()->select(['(costo_por_galon*cantidad_combustible) as total_cost','combustibles.*']);

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'proveedor_id' => $this->proveedor_id,
            'vehiculo_id' => $this->vehiculo_id,
            'tipo_combustible_id'=>$this->tipo_combustible_id
        ]);

        $query->andFilterWhere(['between', 'fecha', $this->fecha_1, $this->fecha_2]);

        return $dataProvider;
    }

    public function searchCombustibleRendimientoFlota($params){
        $query = Combustibles::find()->select(['@kms_recorrido := SUM(combustibles.medicion_actual- COALESCE((SELECT d.medicion_actual FROM combustibles d WHERE d.vehiculo_id = combustibles.vehiculo_id AND d.fecha = (SELECT MAX(fecha) FROM combustibles c WHERE c.vehiculo_id = combustibles.vehiculo_id AND fecha < combustibles.fecha) LIMIT 1),CAST(medicion_actual AS SIGNED) ))  AS kms_recorrido','ROUND(((((SELECT MAX(valor_medicion) FROM mediciones m WHERE combustibles.vehiculo_id = m.vehiculo_id )- combustibles.medicion_actual )/cantidad_combustible)),2) as km_volumen','sum(costo_por_galon)*cantidad_combustible as total_cost','combustibles.*'])->groupBy(['vehiculo_id','proveedor_id']);

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'proveedor_id' => $this->proveedor_id,
            'vehiculo_id' => $this->vehiculo_id,
            'tipo_combustible_id'=>$this->tipo_combustible_id
        ]);

        $query->andFilterWhere(['between', 'fecha', $this->fecha_1, $this->fecha_2]);

        return $dataProvider;
    }

    public function searchCombustibleRendimientoFlotaDetalle($params){
        $query = Combustibles::find()->select(['@kms_recorrido := SUM(combustibles.medicion_actual- COALESCE((SELECT d.medicion_actual FROM combustibles d WHERE d.vehiculo_id = combustibles.vehiculo_id AND d.fecha = (SELECT MAX(fecha) FROM combustibles c WHERE c.vehiculo_id = combustibles.vehiculo_id AND fecha < combustibles.fecha) LIMIT 1),CAST(medicion_actual AS SIGNED) ))  AS kms_recorrido','ROUND((((SELECT MAX(valor_medicion) FROM mediciones m WHERE combustibles.vehiculo_id = m.vehiculo_id )- combustibles.medicion_actual )/cantidad_combustible),2) as km_volumen',' (sum(costo_por_galon* cantidad_combustible)) as total_cost','sum(cantidad_combustible) as total_cant',  'combustibles.*'])->groupBy(['fecha']);

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'proveedor_id' => $this->proveedor_id,
            'vehiculo_id' => $this->vehiculo_id,
            'tipo_combustible_id'=>$this->tipo_combustible_id
        ]);

        $query->andFilterWhere(['between', 'fecha', $this->fecha_1, $this->fecha_2]);

        return $dataProvider;
    }

    public function searchCombustibleRendimientoVehiculo($params){
        $query = Combustibles::find()->select(['@kms_recorrido:=  medicion_actual- COALESCE((SELECT d.medicion_actual FROM combustibles d WHERE d.vehiculo_id = combustibles.vehiculo_id AND d.fecha = (SELECT MAX(fecha) FROM combustibles c WHERE c.vehiculo_id = combustibles.vehiculo_id AND fecha < combustibles.fecha) LIMIT 1),CAST(medicion_actual AS SIGNED) )   as kms_recorrido','ROUND(IFNULL(@kms_recorrido,0)/cantidad_combustible,2) as km_volumen','(costo_por_galon*cantidad_combustible) as total_cost','combustibles.*'])->orderBy("vehiculo_id, fecha DESC");

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'proveedor_id' => $this->proveedor_id,
            'vehiculo_id' => $this->vehiculo_id,
            'tipo_combustible_id'=>$this->tipo_combustible_id,
            'usuario_id' => $this->usuario_id,
        ]);

        $query->andFilterWhere(['between', 'fecha', $this->fecha_1, $this->fecha_2]);

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
        $query = Combustibles::find()->orderBy(['fecha' => SORT_DESC]);
        

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
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'tanqueo_full' => $this->tanqueo_full,
            'costo_por_galon' => $this->costo_por_galon,
            'cantidad_combustible' => $this->cantidad_combustible,
            'vehiculo_id' => $this->vehiculo_id,
            'tipo_combustible_id' => $this->tipo_combustible_id,
            'proveedor_id' => $this->proveedor_id,
            'usuario_id' => $this->usuario_id,
            'centro_costo_id' => $this->centro_costo_id,
            'municipio_id' => $this->municipio_id,
            'departamento_id' => $this->departamento_id,
            'pais_id' => $this->pais_id,
            'grupo_vehiculo_id' => $this->grupo_vehiculo_id,
            'medicion_actual' => $this->medicion_actual,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'numero_tiquete', $this->numero_tiquete]);

        if (!empty($this->fecha)) { //you dont need the if function if yourse sure you have a not null date

            $date_explode = explode(" - ", $this->fecha);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha', $date1, $date2]);
        }
        return $dataProvider;
    }
}
