<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Empresas;
use frontend\models\EmpresasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use yii\db\Query;
use frontend\models\SignupForm;
use yii\filters\AccessControl;

/**
 * EmpresasController implements the CRUD actions for Empresas model.
 */
class EmpresasController extends Controller
{

    //public $layout = 'main-admin';
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
                            'update'
                        ],
                        'roles' => ['p-empresas-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-empresas-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-empresas-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-empresas-eliminar'],
                    ],                ],
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
     * Lists all Empresas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpresasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Empresas model.
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
     * Creates a new Empresas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Empresas();
        $modelUsuario = new SignupForm();

        if (
            $model->load(Yii::$app->request->post()) &&
            $modelUsuario->load(Yii::$app->request->post()) &&
            $model->validate() && $modelUsuario->validate()
        ) {
            $model->save();
            Yii::$app->notificador->enviarCorreoNuevaEmpresa($model);
            $model->almacenarImagen();
            $model->asociarUsuarioAdministrador(Yii::$app->request->post()['SignupForm']);
            Yii::$app->session->setFlash('success', 'Empresa creada correctamente');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        //        if($model->getErrors() || $modelUsuario->getErrors()){
        //            print_r($modelUsuario->getErrors());
        //            echo '<br>';
        //            print_r($model->getErrors());
        //            die();
        //        }
        
        return $this->render('create', [
            'model' => $model,
            'modelUsuario' => $modelUsuario,
        ]);
    }

    /**
     * Updates an existing Empresas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUsuario = User::find()->where(['empresa_id' => $model->id, 'es_administrador_empresa' => 1])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Empresa actualizada correctamente');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelUsuario' => $modelUsuario
        ]);
    }

    /**
     * Deletes an existing Empresas model.
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
     * Finds the Empresas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Empresas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Empresas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUsuariosList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(['id', "concat(id_number,' - ',name,' ',surname) AS text"])
                ->from('user')
                ->where(['like', 'name', $q])
                ->orWhere(['like', 'surname', $q])
                ->orWhere(['like', 'id_number', $q])
                ->andWhere(['=', 'estado', 1]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $user = User::findOne($id);
            $text = $user->id_number . ' - ' . ucwords(strtolower($user->name)) . ' ' . ucwords(strtolower($user->surname));
            $out['results'] = ['id' => $id, 'text' => $text];
        }

        return $out;
    }
}
