<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\DocumentosProveedores;

/**
 * DocumentosProveedoresSearch represents the model behind the search form of `\frontend\models\DocumentosProveedores`.
 */
class DocumentosProveedoresSearch extends DocumentosProveedores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipo_documento_id', 'es_actual', 'proveedor_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['valor_documento'], 'number'],
            [['fecha_expedicion', 'fecha_inicio_cubrimiento', 'fecha_fin_cubrimiento', 'observacion', 'nombre_archivo_original', 'nombre_archivo', 'ruta_archivo', 'creado_el', 'actualizado_el'], 'safe'],
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
    public function search($params,$id)
    {
        $query = DocumentosProveedores::find()->where(['proveedor_id'=>$id]);

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
            'tipo_documento_id' => $this->tipo_documento_id,
            'valor_documento' => $this->valor_documento,
            'fecha_expedicion' => $this->fecha_expedicion,
            'fecha_inicio_cubrimiento' => $this->fecha_inicio_cubrimiento,
            'fecha_fin_cubrimiento' => $this->fecha_fin_cubrimiento,
            'es_actual' => $this->es_actual,
            'proveedor_id' => $this->proveedor_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'nombre_archivo_original', $this->nombre_archivo_original])
            ->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'ruta_archivo', $this->ruta_archivo]);

        return $dataProvider;
    }
}
