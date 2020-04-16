<?php

namespace frontend\controllers;

use frontend\models\MarcasMotores;
use frontend\models\Motores;
use Yii;
use frontend\models\PeriodicidadesTrabajos;
use frontend\models\PeriodicidadesTrabajosSearch;
use frontend\models\Trabajos;
use frontend\models\Vehiculos;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PeriodicidadesTrabajosController implements the CRUD actions for PeriodicidadesTrabajos model.
 */
class PeriodicidadesTrabajosController extends Controller
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
                        'roles' => ['p-periodicidades-trabajos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-periodicidades-trabajos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-periodicidades-trabajos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-periodicidades-trabajos-eliminar'],
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
     * Lists all PeriodicidadesTrabajos models.
     * @return mixed
     */
    public function actionIndex($idTrabajo)
    {
        $searchModel = new PeriodicidadesTrabajosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $idTrabajo);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idTrabajo' => $idTrabajo,
        ]);
    }

    /**
     * Displays a single PeriodicidadesTrabajos model.
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
     * Creates a new PeriodicidadesTrabajos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idTrabajo)
    {
        $model = new PeriodicidadesTrabajos();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->post()['PeriodicidadesTrabajos']['tipo_periodicidad'] == 1) {
                $model->trabajo_id = $idTrabajo;
                $model->save();
            } elseif (Yii::$app->request->post()['PeriodicidadesTrabajos']['tipo_periodicidad'] == 2) {
                $marca = Yii::$app->request->post()['PeriodicidadesTrabajos']['tipos']['marcaVehiculo'];
                $linea = Yii::$app->request->post()['PeriodicidadesTrabajos']['tipos']['lineaMarca'];
                $vehiculos = Vehiculos::find()->where(['marca_vehiculo_id' => $marca])->where(['linea_vehiculo_id' => $linea])->all();
                foreach ($vehiculos as $vehiculo) {
                    $model = new PeriodicidadesTrabajos();
                    $model->load(Yii::$app->request->post());
                    $model->trabajo_id = $idTrabajo;
                    $model->vehiculo_id = $vehiculo->id;
                    $model->save();
                }
            } elseif (Yii::$app->request->post()['PeriodicidadesTrabajos']['tipo_periodicidad'] == 3) {
                $marca = Yii::$app->request->post()['PeriodicidadesTrabajos']['tipos']['marcaMotor'];
                $linea = Yii::$app->request->post()['PeriodicidadesTrabajos']['tipos']['lineaMotor'];
                $tipo = Yii::$app->request->post()['PeriodicidadesTrabajos']['tipos']['tipoVehiculo'];
                $motor = Motores::findOne(['marca_motor_id' => $marca]);
                $vehiculos = Vehiculos::find()->where(['motor_id' => $motor->id])->where(['linea_motor_id' => $linea])->where(['tipo_vehiculo_id' => $tipo])->all();
                foreach ($vehiculos as $vehiculo) {
                    $model = new PeriodicidadesTrabajos();
                    $model->load(Yii::$app->request->post());
                    $model->trabajo_id = $idTrabajo;
                    $model->vehiculo_id = $vehiculo->id;
                    $model->save();
                }
            } elseif (Yii::$app->request->post()['PeriodicidadesTrabajos']['tipo_periodicidad'] == 4) {
                $tipo = Yii::$app->request->post()['PeriodicidadesTrabajos']['tipos']['tipoVehiculo'];
                $vehiculos = Vehiculos::find()->where(['tipo_vehiculo_id' => $tipo])->all();
                foreach ($vehiculos as $vehiculo) {
                    $model = new PeriodicidadesTrabajos();
                    $model->load(Yii::$app->request->post());
                    $model->trabajo_id = $idTrabajo;
                    $model->vehiculo_id = $vehiculo->id;
                    $model->save();
                }
            } elseif (Yii::$app->request->post()['PeriodicidadesTrabajos']['tipo_periodicidad'] == 5) {
                $marca = Yii::$app->request->post()['PeriodicidadesTrabajos']['tipos']['marcaMotor'];
                $linea = Yii::$app->request->post()['PeriodicidadesTrabajos']['tipos']['lineaMotor'];
                $motor = Motores::findOne(['marca_motor_id' => $marca]);
                $vehiculos = Vehiculos::find()->where(['motor_id' => $motor->id])->where(['linea_motor_id' => $linea])->all();
                foreach ($vehiculos as $vehiculo) {
                    $model = new PeriodicidadesTrabajos();
                    $model->load(Yii::$app->request->post());
                    $model->trabajo_id = $idTrabajo;
                    $model->vehiculo_id = $vehiculo->id;
                    $model->save();
                }
            }
            $this->actualizarPeriodicidad($model->trabajo_id);
            return $this->redirect(['index', 'idTrabajo' => $idTrabajo]);
        }

        return $this->render('create', [
            'model' => $model,
            'idTrabajo' => $idTrabajo,
        ]);
    }

    /**
     * Updates an existing PeriodicidadesTrabajos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $trabajo = $model->trabajo_id;

        if ($model->load(Yii::$app->request->post())) {
            $model->trabajo_id = $trabajo;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'idTrabajo' => $model->trabajo_id
        ]);
    }

    /**
     * Deletes an existing PeriodicidadesTrabajos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = PeriodicidadesTrabajos::findOne($id);
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'idTrabajo' => $model->trabajo_id]);
    }

    /**
     * Finds the PeriodicidadesTrabajos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PeriodicidadesTrabajos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PeriodicidadesTrabajos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actualizarPeriodicidad($idTrabajo){
        $trabajo = Trabajos::findOne($idTrabajo);
        $trabajo->periodico = 1;
        $trabajo->save();
        return Yii::$app->session->setFlash("success", 'Se creo la periodicidad');
    }

}
