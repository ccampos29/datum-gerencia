<?php

namespace frontend\controllers;

use frontend\models\Motores;
use Yii;
use frontend\models\PeriodicidadesRutinas;
use frontend\models\PeriodicidadesRutinasSearch;
use frontend\models\Rutinas;
use frontend\models\Vehiculos;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PeriodicidadesRutinasController implements the CRUD actions for PeriodicidadesRutinas model.
 */
class PeriodicidadesRutinasController extends Controller
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
                    'index', 'view', 'create', 'update', 'delete', 'cambiarEstadoRutina'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'update'
                        ],
                        'roles' => ['p-periodicidades-rutinas-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-periodicidades-rutinas-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-periodicidades-rutinas-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-periodicidades-rutinas-eliminar'],
                    ],
                    [
                        'allow' => true,
                        'actions'  => ['cambiarEstadoRutina'],
                        'roles' => ['p-periodicidades-rutinas-cambiarEstadoRutina']
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
     * Lists all PeriodicidadesRutinas models.
     * @return mixed
     */
    public function actionIndex($idRutina)
    {
        $searchModel = new PeriodicidadesRutinasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $idRutina);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idRutina' => $idRutina
        ]);
    }

    /**
     * Displays a single PeriodicidadesRutinas model.
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
     * Creates a new PeriodicidadesRutinas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idRutina)
    {
        $model = new PeriodicidadesRutinas();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->post()['PeriodicidadesRutinas']['tipo_periodicidad'] == 1) {
                $model->rutina_id = $idRutina;
                $model->save();
            } elseif (Yii::$app->request->post()['PeriodicidadesRutinas']['tipo_periodicidad'] == 2) {
                $marca = Yii::$app->request->post()['PeriodicidadesRutinas']['tipos']['marcaVehiculo'];
                $linea = Yii::$app->request->post()['PeriodicidadesRutinas']['tipos']['lineaMarca'];
                $vehiculos = Vehiculos::find()->where(['marca_vehiculo_id' => $marca])->where(['linea_vehiculo_id' => $linea])->all();
                foreach ($vehiculos as $vehiculo) {
                    $model = new PeriodicidadesRutinas();
                    $model->load(Yii::$app->request->post());
                    $model->rutina_id = $idRutina;
                    $model->vehiculo_id = $vehiculo->id;
                    $model->save();
                }
            } elseif (Yii::$app->request->post()['PeriodicidadesRutinas']['tipo_periodicidad'] == 3) {
                $motor = Yii::$app->request->post()['PeriodicidadesRutinas']['tipos']['marcaMotor'];
                $linea = Yii::$app->request->post()['PeriodicidadesRutinas']['tipos']['lineaMotor'];
                $tipo = Yii::$app->request->post()['PeriodicidadesRutinas']['tipos']['tipoVehiculo'];
                $motor = Motores::findOne(['marca_motor_id' => $marca]);
                $vehiculos = Vehiculos::find()->where(['motor_id' => $motor->id])->where(['linea_vehiculo_id' => $linea])->where(['tipo_vehiculo_id' => $tipo])->all();
                foreach ($vehiculos as $vehiculo) {
                    $model = new PeriodicidadesRutinas();
                    $model->load(Yii::$app->request->post());
                    $model->rutina_id = $idRutina;
                    $model->vehiculo_id = $vehiculo->id;
                    $model->save();
                }
            } elseif (Yii::$app->request->post()['PeriodicidadesRutinas']['tipo_periodicidad'] == 4) {
                $tipo = Yii::$app->request->post()['PeriodicidadesRutinas']['tipos']['tipoVehiculo'];
                $vehiculos = Vehiculos::find()->where(['tipo_vehiculo_id' => $tipo])->all();
                foreach ($vehiculos as $vehiculo) {
                    $model = new PeriodicidadesRutinas();
                    $model->load(Yii::$app->request->post());
                    $model->rutina_id = $idRutina;
                    $model->vehiculo_id = $vehiculo->id;
                    $model->save();
                }
            } elseif (Yii::$app->request->post()['PeriodicidadesRutinas']['tipo_periodicidad'] == 5) {
                $motor = Yii::$app->request->post()['PeriodicidadesRutinas']['tipos']['marcaMotor'];
                $linea = Yii::$app->request->post()['PeriodicidadesRutinas']['tipos']['lineaMotor'];
                $motor = Motores::findOne(['marca_motor_id' => $marca]);
                $vehiculos = Vehiculos::find()->where(['motor_id' => $motor->id])->where(['linea_vehiculo_id' => $linea])->all();
                foreach ($vehiculos as $vehiculo) {
                    $model = new PeriodicidadesRutinas();
                    $model->load(Yii::$app->request->post());
                    $model->rutina_id = $idRutina;
                    $model->vehiculo_id = $vehiculo->id;
                    $model->save();
                }
            }
            else {
                print_r($model->errors);
                die();
            }
            $this->cambiarEstadoRutina($idRutina);
            return $this->redirect(['index', 'idRutina' =>$idRutina]);
        }

        return $this->render('create', [
            'model' => $model,
            'idRutina' => $idRutina
        ]);
    }

    /**
     * Updates an existing PeriodicidadesRutinas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $rutina = $model->rutina_id;

        if ($model->load(Yii::$app->request->post())) {
            $model->rutina_id = $rutina;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PeriodicidadesRutinas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = PeriodicidadesRutinas::findOne($id);
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'idRutina' =>$model->rutina_id]);
    }

    /**
     * Finds the PeriodicidadesRutinas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PeriodicidadesRutinas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PeriodicidadesRutinas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function cambiarEstadoRutina($idRutina){
        $rutina = Rutinas::findOne($idRutina);
        $rutina->periodico = 1;
        $rutina->save();
    }
}
