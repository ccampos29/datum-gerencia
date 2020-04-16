<?php

namespace frontend\controllers;

use Yii;
use frontend\models\PropiedadesTrabajos;
use frontend\models\PropiedadesTrabajosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PropiedadesTrabajosController implements the CRUD actions for PropiedadesTrabajos model.
 */
class PropiedadesTrabajosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PropiedadesTrabajos models.
     * @return mixed
     */
    public function actionIndex($idTrabajo)
    {
        $searchModel = new PropiedadesTrabajosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $idTrabajo);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idTrabajo' => $idTrabajo,
        ]);
    }

    /**
     * Displays a single PropiedadesTrabajos model.
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
     * Creates a new PropiedadesTrabajos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idTrabajo)
    {
        $model = new PropiedadesTrabajos();

        if ($model->load(Yii::$app->request->post())) {
            $model->trabajo_id = $idTrabajo;
            if(!$model->save()){
                print_r($model->getErrors());
                die();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'idTrabajo' => $idTrabajo
        ]);
    }

    /**
     * Updates an existing PropiedadesTrabajos model.
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
     * Deletes an existing PropiedadesTrabajos model.
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
     * Finds the PropiedadesTrabajos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PropiedadesTrabajos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PropiedadesTrabajos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
