<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\UsuariosDocumentosUsuarios;

/**
 * UsuariosDocumentosUsuariosSearch represents the model behind the search form of `frontend\models\UsuariosDocumentosUsuarios`.
 */
class UsuariosDocumentosUsuariosSearch extends UsuariosDocumentosUsuarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_documento_id', 'proveedor_id', 'codigo', 'valor_documento', 'actual', 'centro_costo_id', 'creado_por', 'actualizado_por', 'empresa_id', 'usuario_id'], 'integer'],
            [['fecha_expedicion', 'observacion', 'fecha_expiracion', 'creado_el', 'actualizado_el'], 'safe'],
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
        $query = UsuariosDocumentosUsuarios::find();

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
            'usuario_documento_id' => $this->usuario_documento_id,
            'proveedor_id' => $this->proveedor_id,
            'codigo' => $this->codigo,
            'valor_documento' => $this->valor_documento,
            'fecha_expedicion' => $this->fecha_expedicion,
            'actual' => $this->actual,
            // 'fecha_vigencia' => $this->fecha_vigencia,
            'fecha_expiracion' => $this->fecha_expiracion,
            'centro_costo_id' => $this->centro_costo_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'empresa_id' => $this->empresa_id,
            'usuario_id' => $this->usuario_id,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion]);
        $query->andWhere(['usuario_id'=> $_GET['iUs']]);    
        return $dataProvider;
    }
}
