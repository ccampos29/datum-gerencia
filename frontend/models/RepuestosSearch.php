<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Repuestos;

/**
 * RepuestosSearch represents the model behind the search form of `frontend\models\Repuestos`.
 */
class RepuestosSearch extends Repuestos
{
    public $ubicacion_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estado', 'unidad_medida_id', 'grupo_repuesto_id', 'sistema_id', 'subsistema_id', 'cuenta_contable_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['nombre', 'fabricante', 'observacion', 'codigo', 'creado_el', 'actualizado_el','inventariable','ubicacion_id'], 'safe'],
            [['precio'], 'number'],
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
        $query = Repuestos::find();

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
            'precio' => $this->precio,
            'estado' => $this->estado,
            'unidad_medida_id' => $this->unidad_medida_id,
            'grupo_repuesto_id' => $this->grupo_repuesto_id,
            'inventariable' => $this->inventariable,
            'sistema_id' => $this->sistema_id,
            'subsistema_id' => $this->subsistema_id,
            'cuenta_contable_id' => $this->cuenta_contable_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'fabricante', $this->fabricante])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'codigo', $this->codigo]);

        return $dataProvider;
    }



    public function searchUbicacionRepuestos($params)
    {
        $query = InventariosRepuestos::find();

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
        $query->leftJoin('inventarios inventarios', 'inventarios_repuestos.inventario_id=inventarios.id')
            ->leftJoin('ubicaciones_insumos ubicacion', 'inventarios.ubicacion_insumo_id=ubicacion.id');
        if($this->ubicacion_id){
            $query->andFilterWhere(['ubicacion.id' => $this->ubicacion_id]);
        }
        

        

        return $dataProvider;
    }
}
