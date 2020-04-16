<?php

namespace frontend\models;

use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\OrdenesTrabajos;

/**
 * OrdenesTrabajosSearch represents the model behind the search form of `frontend\models\OrdenesTrabajos`.
 */
class OrdenesTrabajosSearch extends OrdenesTrabajos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vehiculo_id', 'medicion', 'proveedor_id', 'disponibilidad', 'tipo_orden_id', 'estado_orden', 'usuario_conductor_id', 'etiqueta_mantenimiento_id', 'centro_costo_id', 'departamento_id', 'municipio_id', 'grupo_vehiculo_id', 'consecutivo', 'total_valor_trabajo', 'total_valor_repuesto', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['fecha_hora_ingreso', 'fecha_hora_orden', 'fecha_hora_cierre', 'observacion', 'creado_el', 'actualizado_el'], 'safe'],
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
        $query = OrdenesTrabajos::find();

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
            'fecha_hora_ingreso' => $this->fecha_hora_ingreso,
            'fecha_hora_orden' => $this->fecha_hora_orden,
            'fecha_hora_cierre' => $this->fecha_hora_cierre,
            'medicion' => $this->medicion,
            'proveedor_id' => $this->proveedor_id,
            'disponibilidad' => $this->disponibilidad,
            'tipo_orden_id' => $this->tipo_orden_id,
            'estado_orden' => $this->estado_orden,
            'usuario_conductor_id' => $this->usuario_conductor_id,
            'etiqueta_mantenimiento_id' => $this->etiqueta_mantenimiento_id,
            'centro_costo_id' => $this->centro_costo_id,
            'municipio_id' => $this->municipio_id,
            'grupo_vehiculo_id' => $this->grupo_vehiculo_id,
            'total_valor_trabajo' => $this->total_valor_trabajo,
            'total_valor_repuesto' => $this->total_valor_repuesto,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion]);

        if (!empty($this->fecha_hora_orden)) { //you dont need the if function if yourse sure you have a not null date

            $date_explode = explode(" - ", $this->fecha_hora_orden);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_hora_orden', $date1, $date2]);
        }

        if (!empty($this->fecha_hora_cierre)) { //you dont need the if function if yourse sure you have a not null date

            $date_explode = explode(" - ", $this->fecha_hora_cierre);
            $date1 = trim($date_explode[0]);
            $date1 = new DateTime($date1);
            $date2 = trim($date_explode[1]);
            $date2 = new DateTime($date2);
            $formato = 'Y-m-d H:i:s';
            //$fecha1 = DateTime::createFromFormat($formato, $date1.' 00:00:00');
            //$fecha2 = DateTime::createFromFormat($formato, $date2.' 11:59:59');
            $query->andFilterWhere(['between', 'fecha_hora_cierre',$date1->format('Y-m-d H:i:s'), $date2->format('Y-m-d H:i:s')]);
        }

        return $dataProvider;
    }
}
