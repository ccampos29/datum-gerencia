<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\VehiculosOtrosDocumentos;

/**
 * VehiculosDocumentosSearch represents the model behind the search form of `frontend\models\VehiculosOtrosDocumentos`.
 */
class VehiculosDocumentosSearch extends VehiculosOtrosDocumentos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'centro_costo_id', 'tipo_documento_id', 'proveedor_id', 'vehiculo_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['codigo', 'fecha_expedicion', 'fecha_vigencia', 'fecha_expiracion', 'descripcion', 'creado_el', 'actualizado_el'], 'safe'],
            [['valor_unitario'], 'number'],
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
     * Búsqueda documentos por vehiculo
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchDocumentosVehiculo($params){

        $query = VehiculosOtrosDocumentos::find();

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
        if(!empty($_GET['idv']))
        {
            $query = VehiculosOtrosDocumentos::find()->where(['vehiculo_id'=>$_GET['idv']]);
        }else{
            $query = VehiculosOtrosDocumentos::find();
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'valor_unitario' => $this->valor_unitario,
            'fecha_expedicion' => $this->fecha_expedicion,
            'fecha_vigencia' => $this->fecha_vigencia,
            //'fecha_expiracion' => $this->fecha_expiracion,
            'centro_costo_id' => $this->centro_costo_id,
            'tipo_documento_id' => $this->tipo_documento_id,
            'proveedor_id' => $this->proveedor_id,
            'vehiculo_id' => $this->vehiculo_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'valor_unitario', $this->valor_unitario])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        if (!empty($this->fecha_expiracion)) { //you dont need the if function if yourse sure you have a not null date
            $date_explode = explode(" - ", $this->fecha_expiracion);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_expiracion', $date1, $date2]);
        }
        
        return $dataProvider;
    }
}
