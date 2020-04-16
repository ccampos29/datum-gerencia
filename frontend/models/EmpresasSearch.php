<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Empresas;

/**
 * EmpresasSearch represents the model behind the search form of `frontend\models\Empresas`.
 */
class EmpresasSearch extends Empresas
{
    public $usuario_principal_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'creado_por', 'actualizado_por'], 'integer'],
            [['usuario_principal_id','nombre', 'nit_identificacion', 'digito_verificacion', 'numero_fijo', 'numero_celular', 'correo_contacto', 'direccion', 'fecha_inicio_licencia', 'fecha_fin_licencia', 'creado_el', 'actualizado_el', 'tipo'], 'safe'],
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
        $query = Empresas::find();

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
            'fecha_inicio_licencia' => $this->fecha_inicio_licencia,
            'fecha_fin_licencia' => $this->fecha_fin_licencia,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'nit_identificacion', $this->nit_identificacion])
            ->andFilterWhere(['like', 'digito_verificacion', $this->digito_verificacion])
            ->andFilterWhere(['like', 'numero_fijo', $this->numero_fijo])
            ->andFilterWhere(['like', 'numero_celular', $this->numero_celular])
            ->andFilterWhere(['like', 'correo_contacto', $this->correo_contacto])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'tipo', $this->tipo]);

        if(!empty($this->usuario_principal_id)){
            $query->leftJoin('user usuario', 'empresas.usuario_principal_id='.$this->usuario_principal_id);
        }

        return $dataProvider;
    }
}
