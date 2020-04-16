<?php

namespace frontend\controllers;

use Yii;
use frontend\models\OtrosGastos;
use frontend\models\OtrosGastosSearch;
use frontend\models\TiposUsuarios;
use yii\db\IntegrityException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OtrosGastosController implements the CRUD actions for OtrosGastos model.
 */
class OtrosGastosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'update'
                        ],
                        'roles' => ['p-otros-gastos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-otros-gastos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-otros-gastos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-otros-gastos-eliminar'],
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
     * Lists all OtrosGastos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OtrosGastosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OtrosGastos model.
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
     * Creates a new OtrosGastos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OtrosGastos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            print_r($model->tipo_descuento);
            //die();
            if ($model->tipo_descuento == 2 && !empty(Yii::$app->request->post()['OtrosGastos']['gastos'])) {
                $model->cantidad_descuento = Yii::$app->request->post()['OtrosGastos']['gastos'];
                print($model->tipo_descuento);

                //die();
            }
            $model->save();
            Yii::$app->session->setFlash("success", 'Otro gasto asignado a un vehiculo con exito.');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            echo Yii::$app->ayudante->getErroresSave($model);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OtrosGastos model.
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
     * Deletes an existing OtrosGastos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $this->findModel($id)->delete();
            $transaction->commit();
            Yii::$app->session->setFlash('success', 'El registro fue eliminado correctamente.');
            return $this->redirect(['index']);
        } catch (IntegrityException $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'No puede eliminar este registro, se deben eliminar los registros asociados antes.');
            return $this->redirect(['index']);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'No se puede eliminar este registro.');
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the OtrosGastos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OtrosGastos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OtrosGastos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionEmailOtrosGastos($id)
    {
        $model = $this->findModel($id);
        Yii::$app->notificador->emailOtrosGastos($model);
        Yii::$app->session->setFlash('success', 'Se ha enviado el correo satisfactoriamente.');
        return $this->redirect(['index']);
    }
}
