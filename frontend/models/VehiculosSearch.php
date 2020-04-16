<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Vehiculos;
use Yii;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * VehiculosSearch represents the model behind the search form of `frontend\models\Vehiculos`.
 */
class VehiculosSearch extends Vehiculos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'modelo', 'numero_chasis', 'numero_serie', 'cantidad_sillas', 'numero_importacion', 'vehiculo_imei_gps', 'marca_vehiculo_id', 'linea_vehiculo_id', 'motor_id', 'linea_motor_id', 'tipo_vehiculo_id', 'tipo_medicion', 'tipo_servicio', 'tipo_trabajo', 'tipo_combustible_id', 'centro_costo_id', 'vehiculo_equipo', 'municipio_id', 'departamento_id', 'pais_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['fecha_1', 'fecha_2', 'fecha2_1', 'fecha2_2', 'tipo_vehiculo_id', 'marca_vehiculo_id', 'linea_vehiculo_id', 'tipo_servicio', 'tipo_combustible_id', 'placa', 'color', 'observaciones', 'propietario_vehiculo', 'tipo_carroceria', 'codigo_fasecolda', 'fecha_compra', 'nombre_vendedor', 'fecha_importacion', 'vehiculo_equipo_observacion', 'creado_el', 'actualizado_el'], 'safe'],
            [['distancia_maxima', 'distancia_promedio', 'horas_dia', 'toneladas_carga', 'medicion_compra', 'precio_accesorios'], 'number'],
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

    public function searchRecorridoVehiculos($params)
    {
        $query = Combustibles::find()->select(['@recorrido := SUM(combustibles.medicion_actual- COALESCE((SELECT d.medicion_actual FROM combustibles d WHERE d.vehiculo_id = combustibles.vehiculo_id AND d.fecha = (SELECT MAX(fecha) FROM combustibles c WHERE c.vehiculo_id = combustibles.vehiculo_id AND fecha < combustibles.fecha) LIMIT 1),CAST(medicion_actual AS SIGNED) ))  AS kms_recorrido', '@dias_recorridos := DATEDIFF(MAX(fecha), MIN(fecha)) as dias_recorridos', ' ROUND(IFNULL(@kms_recorrido,0)/ IFNULL((DATEDIFF(MAX(fecha), MIN(fecha))),0) ,1) as promedio_dias_recorridos', 'combustibles.*'])->groupBy('vehiculo_id');

        $dataProvider = $this->callingDataProvider($query, $params);

        $query->andFilterWhere([
            'vehiculo_id' => $this->id,
            /*'vehiculo_id' => $this->vehiculo_id,
            'tipo_combustible_id'=>$this->tipo_combustible_id,
            'usuario_id' => $this->usuario_id, */
        ]);

        $query->andFilterWhere(['between', 'fecha_medicion', $this->fecha_1, $this->fecha_2]);

        return $dataProvider;
    }


    public function searchCostosMedicion($params,$fecha1=NULL, $fecha2=NULL,$vehiculo=NULL)
    {

        if($fecha1== NULL and $fecha2 ==NULL){
            $fecha1 = '2000-01-01';
            $fecha2 = '3000-01-01';
        }

        $vehiculo = $vehiculo == NULL ? '' : "AND vehiculos.id ={$vehiculo} ";

        $sql = "SELECT vehiculos.id as id_vehi, '{$fecha1}' as fecha1,'{$fecha2}' as fecha2, placa,tv.descripcion as tipo_vehiculo, mv.descripcion as marca, lv.descripcion as linea, @total_valor_t:=(SELECT COALESCE(SUM(o.total_valor_trabajo),0) FROM ordenes_trabajos o WHERE o.vehiculo_id = vehiculos.id AND fecha_hora_orden BETWEEN '{$fecha1}' AND '{$fecha2}') AS total_valor_trabajo, @total_valor_r:=(SELECT COALESCE(SUM(o.total_valor_repuesto),0) FROM ordenes_trabajos o WHERE o.vehiculo_id = vehiculos.id AND fecha_hora_orden BETWEEN '{$fecha1}' AND '{$fecha2}') AS total_valor_repuesto, @total_valor_c:=(SELECT coalesce(SUM(c.costo_por_galon*c.cantidad_combustible), 0) FROM combustibles c WHERE c.vehiculo_id = vehiculos.id AND fecha BETWEEN '{$fecha1}' AND '{$fecha2}') AS total_combustible, @total_valor_o:=(SELECT COALESCE(SUM( IF(og.tipo_impuesto_id = 4,(og.valor_unitario * 1.19),og.valor_unitario  )),0) FROM otros_gastos og WHERE og.vehiculo_id = vehiculos.id AND fecha BETWEEN '{$fecha1}' AND '{$fecha2}') AS total_otros_gastos, @costo_total := COALESCE((SELECT SUM(IFNULL(@total_valor_t, 0) + IFNULL(@total_valor_r, 0) + IFNULL(@total_valor_c, 0) + IFNULL(@total_valor_o, 0))),0) as costo_total, @recorrido := SUM(cm.medicion_actual- COALESCE((SELECT d.medicion_actual FROM combustibles d WHERE d.vehiculo_id = cm.vehiculo_id AND cm.fecha BETWEEN '{$fecha1}' AND '{$fecha2}' AND d.fecha = (SELECT MAX(fecha) FROM combustibles c WHERE c.vehiculo_id = cm.vehiculo_id AND fecha < cm.fecha) LIMIT 1),CAST(medicion_actual AS SIGNED) ))  AS recorrido, vehiculos.tipo_medicion as medicion, COALESCE(ROUND(IFNULL(@costo_total, 0)/IFNULL(@recorrido, 0),2),0) as costo_por_unidad FROM vehiculos, tipos_vehiculos tv, marcas_vehiculos mv, lineas_marcas lv, combustibles cm WHERE vehiculos.tipo_vehiculo_id = tv.id AND mv.id = vehiculos.marca_vehiculo_id AND lv.id = vehiculos.linea_vehiculo_id  AND cm.vehiculo_id = vehiculos.id $vehiculo GROUP BY vehiculos.id";

        $totalCount = Yii::$app->db->createCommand('SELECT COUNT(*) FROM vehiculos')->queryScalar();

        $dataProvider =  new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $totalCount,
        //    'params' => $params

        ]);
   
        return $dataProvider;
    }


    public function searchFlotaConductores($params)
    {
        $query = Vehiculos::find()->innerJoinWith('ordenesTrabajos');

        $dataProvider = $this->callingDataProvider($query, $params);

        $query->andFilterWhere([
            /* 'proveedor_id' => $this->proveedor_id,
            'vehiculo_id' => $this->vehiculo_id,
            'tipo_combustible_id'=>$this->tipo_combustible_id,
            'usuario_id' => $this->usuario_id, */]);

        //   $query->andFilterWhere(['between', 'fecha_desde', $this->fecha_1, $this->fecha_2]);
        //   $query->andFilterWhere(['between', 'fecha_hasta', $this->fecha2_1, $this->fecha2_2]);

        return $dataProvider;
    }

    public function searchFlotaGeneral($params)
    {
        $query = Vehiculos::find();

        $dataProvider = $this->callingDataProvider($query, $params);

        $query->andFilterWhere([
            'id' => $this->placa,
            'tipo_combustible_id' => $this->tipo_combustible_id,
            'tipo_vehiculo_id' => $this->tipo_vehiculo_id,
        ]);

        $query->andFilterWhere(['between', 'fecha_compra', $this->fecha_1, $this->fecha_2]);

        return $dataProvider;
    }
    /**
     * Implementación DataProvider
     * @return ActiveDataProvider
     */
    public function callingDataProvider($query, $params)
    {
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
        $query = Vehiculos::find();

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
            'modelo' => $this->modelo,
            'distancia_maxima' => $this->distancia_maxima,
            'distancia_promedio' => $this->distancia_promedio,
            'horas_dia' => $this->horas_dia,
            'numero_chasis' => $this->numero_chasis,
            'numero_serie' => $this->numero_serie,
            'cantidad_sillas' => $this->cantidad_sillas,
            'toneladas_carga' => $this->toneladas_carga,
            'fecha_compra' => $this->fecha_compra,
            'medicion_compra' => $this->medicion_compra,
            'precio_accesorios' => $this->precio_accesorios,
            'numero_importacion' => $this->numero_importacion,
            'fecha_importacion' => $this->fecha_importacion,
            'vehiculo_imei_gps' => $this->vehiculo_imei_gps,
            'marca_vehiculo_id' => $this->marca_vehiculo_id,
            'linea_vehiculo_id' => $this->linea_vehiculo_id,
            'motor_id' => $this->motor_id,
            'linea_motor_id' => $this->linea_motor_id,
            'tipo_vehiculo_id' => $this->tipo_vehiculo_id,
            'tipo_medicion' => $this->tipo_medicion,
            'tipo_servicio' => $this->tipo_servicio,
            'tipo_trabajo' => $this->tipo_trabajo,
            'tipo_combustible_id' => $this->tipo_combustible_id,
            'centro_costo_id' => $this->centro_costo_id,
            'vehiculo_equipo' => $this->vehiculo_equipo,
            'municipio_id' => $this->municipio_id,
            'departamento_id' => $this->departamento_id,
            'pais_id' => $this->pais_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'placa', $this->placa])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'propietario_vehiculo', $this->propietario_vehiculo])
            ->andFilterWhere(['like', 'tipo_carroceria', $this->tipo_carroceria])
            ->andFilterWhere(['like', 'codigo_fasecolda', $this->codigo_fasecolda])
            ->andFilterWhere(['like', 'nombre_vendedor', $this->nombre_vendedor])
            ->andFilterWhere(['like', 'vehiculo_equipo_observacion', $this->vehiculo_equipo_observacion]);

        return $dataProvider;
    }
}
