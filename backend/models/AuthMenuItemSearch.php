<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AuthMenuItem;

/**
 * AuthMenuItemSearch represents the model behind the search form about `common\models\AuthMenuItem`.
 */
class AuthMenuItemSearch extends AuthMenuItem {
    public function rules() {
        return [
            [['id', 'padre', 'orden', 'visible', 'separador'], 'integer'],
            [['auth_item', 'name', 'label', 'ruta', 'icono', 'tipo', 'descripcion'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        /**
         * NOTA: No se incluye el root, porque al no tener padre
         * genera excepciones en las acciones. 
         */
        $query = AuthMenuItem::find()
                ->where('id > :idRoot', [':idRoot' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'padre' => $this->padre,
            'orden' => $this->orden,
            'visible' => $this->visible,
            'separador' => $this->separador,
        ]);

        $query->andFilterWhere(['like', 'auth_item', $this->auth_item])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'ruta', $this->ruta])
            ->andFilterWhere(['like', 'icono', $this->icono])
            ->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
