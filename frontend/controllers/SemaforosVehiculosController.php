<?php

namespace frontend\controllers;

use Yii;
use frontend\models\SemaforosVehiculos;
use frontend\models\SemaforosVehiculosSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SemaforosVehiculosController implements the CRUD actions for SemaforosVehiculos model.
 */
class SemaforosVehiculosController extends Controller
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
                        'roles' => ['p-semaforos-vehiculos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-semaforos-vehiculos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-semaforos-vehiculos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-semaforos-vehiculos-eliminar'],
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
     * Lists all SemaforosVehiculos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SemaforosVehiculosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SemaforosVehiculos model.
     * @param string $id
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
     * Creates a new SemaforosVehiculos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SemaforosVehiculos();

        $indicadores = ['Bueno'=>['color'=>'green'],'Regular'=>['color'=>'orange'],'Malo'=>['color'=>'red']];
        
        $semaforos = $this->createBasedIndicators($indicadores, $_GET['idv']);
        
        if ($model->load(Yii::$app->request->post())) {
            
            $request     = Yii::$app->request;
            $indicads    = $request->post()['SemaforosVehiculos']['indicador'];
            
            foreach($semaforos as $key=>$semaforo){
                $semaforo->indicador = $indicads[$key];
                $semaforo->desde     = $request->post()['SemaforosVehiculos']['desde'][$key];
                $semaforo->hasta     = $request->post()['SemaforosVehiculos']['hasta'][$key];
                $semaforo->vehiculo_id = $request->post()['SemaforosVehiculos']['vehiculo_id'];
                if(!$semaforo->save()){
                    echo Yii::$app->ayudante->getErroresSave($model); 
                }
            } 
            
            return $this->redirect(['index', 'idv' => $_GET['idv']]);
        }
        
        return $this->render('create', [
            'model' => $model,
            'indicadores'=>$indicadores,
            'semaforos' =>$semaforos 
        ]);
    }

    /**
     * Crea la base para los indicadores
     */
    protected static function createBasedIndicators($indicadores, $idVehiculo){
        $semaforos   = SemaforosVehiculos::find()->where(['vehiculo_id' => $idVehiculo])->all();

        if(empty($semaforos)){
            foreach($indicadores as $key=>$indicador){
                $model            = new SemaforosVehiculos();
                $model->indicador = $key;
                $model->desde     = 0;
                $model->hasta     = 0;
                $model->vehiculo_id = $idVehiculo;
                if(!$model->save()){
                        echo Yii::$app->ayudante->getErroresSave($model);    
                }
            }
            return SemaforosVehiculos::find()->where(['vehiculo_id' => $idVehiculo])->all();
        }

        return $semaforos;
    }

    /**
     * Updates an existing SemaforosVehiculos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing SemaforosVehiculos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (yii\db\Exception $e) {
            Yii::$app->session->setFlash('danger', 'No puede eliminar este registro, se deben eliminar los registros asociados antes.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the SemaforosVehiculos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SemaforosVehiculos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SemaforosVehiculos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
