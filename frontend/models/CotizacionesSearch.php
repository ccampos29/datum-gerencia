<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Cotizaciones;

/**
 * CotizacionesSearch represents the model behind the search form of `frontend\models\Cotizaciones`.
 */
class CotizacionesSearch extends Cotizaciones
{

    public $fecha_inicio_cotizacion;
    public $fecha_fin_cotizacion;
    public $fecha_inicio_vigencia;
    public $fecha_fin_vigencia;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'solicitud_id', 'estado', 'proveedor_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['fecha_hora_cotizacion', 'fecha_hora_vigencia', 'observacion', 'creado_el', 'actualizado_el', 'fecha_inicio_cotizacion', 'fecha_fin_cotizacion', 'fecha_inicio_vigencia', 'fecha_fin_vigencia'], 'safe'],
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
    public function search($params, $idSolicitud)
    {
        $query = Cotizaciones::find()->where(['solicitud_id' => $idSolicitud]);

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
            'fecha_hora_cotizacion' => $this->fecha_hora_cotizacion,
            'solicitud_id' => $this->solicitud_id,
            'proveedor_id' => $this->proveedor_id,
            'estado' => $this->estado,
            'fecha_hora_vigencia' => $this->fecha_hora_vigencia,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'empresa_id' => $this->empresa_id,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion]);

        if (!empty($this->fecha_hora_cotizacion)) { //you dont need the if function if yourse sure you have a not null date

            $date_explode = explode(" - ", $this->fecha_hora_cotizacion);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_hora_cotizacion', $date1, $date2]);
        }

        if (!empty($this->fecha_hora_vigencia)) { //you dont need the if function if yourse sure you have a not null date

            $date_explode = explode(" - ", $this->fecha_hora_vigencia);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_hora_vigencia', $date1, $date2]);
        }

        return $dataProvider;
    }

    public function searchCotizacionesConsulta($params)
    {
        // print_r($params);
        // die();
        $query = Cotizaciones::find();

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
            'solicitud_id' => $this->solicitud_id,
            'proveedor_id' => $this->proveedor_id,
        ]);

        if (!empty($this->fecha_inicio_cotizacion) && !empty($this->fecha_fin_cotizacion)) { //you dont need the if function if yourse sure you have a not null date
            $query->andFilterWhere(['between', 'fecha_hora_cotizacion', $this->fecha_inicio_cotizacion, $this->fecha_fin_cotizacion]);
        }
        if (!empty($this->fecha_inicio_vigencia) && !empty($this->fecha_fin_vigencia)) { //you dont need the if function if yourse sure you have a not null date
            $query->andFilterWhere(['between', 'fecha_hora_vigencia', $this->fecha_inicio_vigencia, $this->fecha_fin_vigencia]);
        }




        return $dataProvider;
    }
}
