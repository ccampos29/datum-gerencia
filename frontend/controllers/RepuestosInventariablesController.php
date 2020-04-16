<?php

namespace frontend\controllers;

use frontend\models\Repuestos;
use Yii;
use frontend\models\RepuestosInventariables;
use frontend\models\RepuestosInventariablesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RepuestosInventariablesController implements the CRUD actions for RepuestosInventariables model.
 */
class RepuestosInventariablesController extends Controller
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
                        'roles' => ['p-repuestos-inventariables-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-repuestos-inventariables-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-repuestos-inventariables-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-repuestos-inventariables-eliminar'],
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
     * Lists all RepuestosInventariables models.
     * @return mixed
     */
    public function actionIndex($idRepuesto)
    {
        $searchModel = new RepuestosInventariablesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $idRepuesto);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idRepuesto' => $idRepuesto,
        ]);
    }

    /**
     * Displays a single RepuestosInventariables model.
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
     * Creates a new RepuestosInventariables model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idRepuesto)
    {
        $model = new RepuestosInventariables();

        if ($model->load(Yii::$app->request->post())) {
            $model->repuesto_id = $idRepuesto;
            $model->save();
            Yii::$app->session->setFlash("success", 'Repuesto Inventariable creado con éxito.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'idRepuesto' => $idRepuesto,
        ]);
    }

    /**
     * Updates an existing RepuestosInventariables model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $repuesto = $model->repuesto_id;

        if ($model->load(Yii::$app->request->post())) {
            $model->repuesto_id = $repuesto;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RepuestosInventariables model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = RepuestosInventariables::findOne($id);
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'idRepuesto' => $model->repuesto_id]);
    }

    /**
     * Finds the RepuestosInventariables model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RepuestosInventariables the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RepuestosInventariables::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionIrCantidad($idRepuesto)
    {
        $repuesto = Repuestos::findOne($idRepuesto);
        if ($repuesto->inventariable == 1) {
            return $this->redirect(['index', 'idRepuesto' => $idRepuesto]);
        } else {
            Yii::$app->session->setFlash("danger", 'El repuesto no es inventariable');
            return $this->redirect(['repuestos/index']);
        }
    }
}
