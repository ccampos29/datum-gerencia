<?php

namespace frontend\controllers;

use frontend\models\PropiedadesTrabajos;
use Yii;
use frontend\models\Trabajos;
use frontend\models\TrabajosSearch;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TrabajosController implements the CRUD actions for Trabajos model.
 */
class TrabajosController extends Controller
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
                            'update'
                        ],
                        'roles' => ['p-trabajos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-trabajos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-trabajos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-trabajos-eliminar'],
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
     * Lists all Trabajos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrabajosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Trabajos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $propiedades = PropiedadesTrabajos::find()->where(['trabajo_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'propiedades' => $propiedades
        ]);
    }

    /**
     * Creates a new Trabajos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Trabajos();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->periodico = 0;
            $model->save();
            Yii::$app->session->setFlash("success", 'Trabajo creado con éxito.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Trabajos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Trabajos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->sePuedeEliminar()) {
            $modelTmp = $model;
            //$model->delete();
            $model->antesDelete();
            $model->delete();
            Yii::$app->session->setFlash("success", 'Se eliminó el Trabajo: '
                . $modelTmp->nombre . ' correctamente');
        } else {
            $detalle = $model->objetosRelacionados();
            Yii::$app->session->setFlash("error", 'El trabajo ' . $model->nombre .
                " no se puede eliminar porque primero: <br/>" . $detalle);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Trabajos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Trabajos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trabajos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Ajax para la carga de los trabajos en el select2 que esta 
     * en el formulario de Mantenimientos, Novedades Mantenimientos
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionTrabajosList($q = null, $id = null)
    {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, nombre AS text', 'trabajos');
    }
}
