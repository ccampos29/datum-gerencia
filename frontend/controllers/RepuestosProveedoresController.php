<?php

namespace frontend\controllers;

use frontend\models\Repuestos;
use Yii;
use frontend\models\RepuestosProveedores;
use frontend\models\RepuestosProveedoresSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RepuestosProveedoresController implements the CRUD actions for RepuestosProveedores model.
 */
class RepuestosProveedoresController extends Controller
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
                        'roles' => ['p-repuestos-proveedores-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-repuestos-proveedores-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-repuestos-proveedores-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-repuestos-proveedores-eliminar'],
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
     * Lists all RepuestosProveedores models.
     * @return mixed
     */
    public function actionIndex($idRepuesto)
    {
        $searchModel = new RepuestosProveedoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $idRepuesto);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idRepuesto' => $idRepuesto,
        ]);
    }

    /**
     * Displays a single RepuestosProveedores model.
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
     * Creates a new RepuestosProveedores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idRepuesto)
    {
        $model = new RepuestosProveedores();

        if ($model->load(Yii::$app->request->post())) {
            $model->repuesto_id = $idRepuesto;
            if ($model->validate()) {
                $model->save();
                Yii::$app->session->setFlash("success", 'Repuesto por Proveedor creado con éxito.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'idRepuesto' => $idRepuesto,
        ]);
    }

    /**
     * Updates an existing RepuestosProveedores model.
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
     * Deletes an existing RepuestosProveedores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = RepuestosProveedores::findOne($id);
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'idRepuesto' => $model->repuesto_id]);
    }

    /**
     * Finds the RepuestosProveedores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RepuestosProveedores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RepuestosProveedores::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
