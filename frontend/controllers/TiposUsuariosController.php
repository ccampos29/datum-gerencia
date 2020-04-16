<?php

namespace frontend\controllers;

use backend\models\AuthItem;
use backend\models\AuthItemChild;
use Yii;
use frontend\models\TiposUsuarios;
use frontend\models\TiposUsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\filters\AccessControl;

/**
 * TiposUsuariosController implements the CRUD actions for TiposUsuarios model.
 */
class TiposUsuariosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'index', 'view', 'create', 'update', 'delete',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'view', 'create', 'update'
                        ],
                        'roles' => ['p-tipos-usuarios-ver', 'p-tipos-usuarios-crear', 'p-tipos-usuarios-actualizar', '@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'index'
                        ],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'delete'
                        ],
                        'roles' => ['p-tipos-usuarios-eliminar'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TiposUsuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TiposUsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TiposUsuarios model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TiposUsuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TiposUsuarios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Tipo de usuario creado correctamente');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TiposUsuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Tipo de usuario actualizado correctamente');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TiposUsuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TiposUsuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TiposUsuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TiposUsuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
    /**
     * Ajax para la carga de los centro de costo en el select2 que esta 
     * en el formulario de usuarios
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionTiposUsuariosList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, descripcion AS text')
                    ->from('tipos_usuarios')
                    ->where(['like', 'descripcion', $q])
                    ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => TiposUsuarios::find($id)->nombre];
        }
        return $out;
    }


    /**
     * Ajax para la carga de los roles en el select2 que esta 
     * en el formulario de tipos_usuarios
     * Este ajax va aquí para no tocar la parte administrativa
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionRolesPermisosList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('name as id,name AS text')
                    ->from('auth_item')
                    ->where(['like', 'name', $q])
                    ->andWhere(['<>', 'name', 'r-admin'])
                    ->andWhere(['<>', 'name', 'r-super-admin'])
                    ->andWhere(['<>', 'name', 'r-administrador-empresa'])
                    ->andWhere(['=', 'type', '1'])
                    ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id != null) {
            $out['results'] = ['id' => $id, 'text' => AuthItem::find()->where(['name'=> $id])->name];
        }
        return $out;
    }
    /**
     * Método para llenar un select-ajax
     * @param string $q Valor a buscar
     * @param array query resultado 
     * @return array Resultados encontrados según la búsqueda 
     */
    public function actionTiposList($q = null, $id = null) {
        {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $out = ['results' => ['id' => '', 'text' => '']];
            $query = new Query;
            $query->select('id, descripcion AS text')
                ->from('tipos_usuarios')
                ->andFilterWhere(['like', 'descripcion', $q]);
                
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
            return $out;
        }
    }

}
