<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Combustibles;
use frontend\models\CombustiblesSearch;
use frontend\models\ImagenesCombustibles;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Vehiculos;
use SoapClient;
use SoapHeader;
use yii\db\IntegrityException;
use yii\filters\AccessControl;
use yii\helpers\Json;
/**
 * CombustiblesController implements the CRUD actions for Combustibles model.
 */
class CombustiblesController extends Controller
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
                        'roles' => [ 'p-combustibles-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-combustibles-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-combustibles-crear'],
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
                        'roles' => ['p-combustibles-eliminar'],
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
     * Lists all Combustibles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CombustiblesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Combustibles agrupados por proveedor
     */
    public function actionCombustibleProveedor(){

        $searchModel = new CombustiblesSearch();
        $dataProvider = $searchModel->searchCombustibleProveedor(Yii::$app->request->queryParams);

        return $this->render('consultas/combustible_proveedor', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }
    /**
     * Combustibles agrupados por centros de costos
     */
    public function actionCombustibleCentrosCostos(){

        $searchModel = new CombustiblesSearch();
        $dataProvider = $searchModel->searchCombustibleCentroCostos(Yii::$app->request->queryParams);

        return $this->render('consultas/combustible_centro_costos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }
    /**
     * Combustibles agrupados por vehiculo y proveedor
     */
    public function actionCombustibleVehiculoProveedor(){

        $searchModel = new CombustiblesSearch();
        $dataProvider = $searchModel->searchCombustibleVehiculoProveedor(Yii::$app->request->queryParams);

        return $this->render('consultas/combustible_vehiculo_proveedor', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }    

    /**
     * Combustibles agrupados por vehiculo y proveedor
     */
    public function actionCombustibleDetalleProveedor(){

        $searchModel = new CombustiblesSearch();
        $dataProvider = $searchModel->searchCombustibleDetalleProveedor(Yii::$app->request->queryParams);

        return $this->render('consultas/combustible_detalle_proveedor', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }  
        /**
     * Combustibles agrupados por vehiculo y proveedor
     */
    public function actionCombustibleRendimientoFlota(){

        $searchModel = new CombustiblesSearch();
        $dataProvider = $searchModel->searchCombustibleRendimientoFlota(Yii::$app->request->queryParams);

        return $this->render('consultas/combustible_rendimiento_flota', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }  

    /**
     * Combustibles agrupados por vehiculo y proveedor
     */
    public function actionCombustibleRendimientoFlotaDetalle(){

        $searchModel = new CombustiblesSearch();
        $dataProvider = $searchModel->searchCombustibleRendimientoFlotaDetalle(Yii::$app->request->queryParams);

        return $this->render('consultas/combustible_rendimiento_flota_detalle', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }  

    /**
     * Combustibles agrupados por vehiculo y proveedor
     */
    public function actionCombustibleRendimientoVehiculo(){

        $searchModel = new CombustiblesSearch();
        $dataProvider = $searchModel->searchCombustibleRendimientoVehiculo(Yii::$app->request->queryParams);

        return $this->render('consultas/combustible_rendimiento_vehiculo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }  

    /**
     * Displays a single Combustibles model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $modelImagenes  = ImagenesCombustibles::find()->where(['combustible_id' => $id])->orderBy(['id'=>SORT_DESC])->one();
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'total' => $model->costo_por_galon*$model->cantidad_combustible,
            'imagenes' => $modelImagenes,
        ]);
    }

    /**
     * Creates a new Combustibles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Combustibles();
        if ($model->load(Yii::$app->request->post())) {
            $valMedicionFicticio=Yii::$app->request->post()['Combustibles']['medicion_compare'];
            $valMedicion=Yii::$app->request->post()['Combustibles']['medicion_actual'];
            
            if($valMedicionFicticio < $valMedicion){
                Yii::$app->session->setFlash("danger", 'El valor de la medicion no puede ser mayor al reportado por web service.');
                return $this->redirect(['create']);
            }else{
                if ($model->save()) {
                    $model->almacenarImagenes($model->id);
                    $medicion = $this->actionConsultaMedicion($model->vehiculo_id);
                    $medicion = Json::decode($medicion);
                    $model->almacenarMedicion($medicion, $model->vehiculo_id);
                    Yii::$app->session->setFlash("success", 'Tanqueo registrado con éxito.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    echo Yii::$app->ayudante->getErroresSave($model);
                }
            }
            
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Combustibles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->almacenarImagenes($model->id);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Combustibles model.
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
            $this->findModel($id)->antesDelete();
            $this->findModel($id)->delete();
            $transaction->commit();
            Yii::$app->session->setFlash('success','El registro fue eliminado correctamente.');
            return $this->redirect(['index']);
    
        } catch (IntegrityException $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error','No puede eliminar este registro, se deben eliminar los registros asociados antes.');
            return $this->redirect(['index']);
    
        }catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error','No se puede eliminar este registro.');
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Combustibles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Combustibles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Combustibles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionConsultaMedicion($idVehiculo)
    {
        $vehiculo = new Vehiculos;

        $vehiculo = Vehiculos::findOne($idVehiculo);
        $username = 'wsdatumpos';
        $password = 'Ddatum_pepe123*';
        $placas = $vehiculo->placa;



        $soapURL = "http://190.143.101.58:2998/VideoData.asmx?WSDL";

        $client = new SoapClient($soapURL, array());

        $auth = array(
            'sUser' => $username,
            'sPassw' => $password,
            'sPlate' => $placas,
        );

         if ($vehiculo->tipo_medicion == 'KMS') {
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithOdometerResult', $auth, false);
            $client->__setSoapHeaders($head);


            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithOdometer($auth)->GetLastPositionWithOdometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor" => $value['Odometro'], "estado" => $value['NEvento'], "fecha" => $value['Fecha'], "hora" => $value['Hora'], "tipo" => $vehiculo->tipo_medicion, "placa"=>$vehiculo->placa, "function" => 'odom'];

            return Json::encode($val);
        } else {
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithHorometerResult', $auth, false);
            $client->__setSoapHeaders($head);


            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithHorometer($auth)->GetLastPositionWithHorometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor" => $value['Horometro'], "estado" => $value['NEvento'], "fecha" => $value['Fecha'], "hora" => $value['Hora'], "tipo" => $vehiculo->tipo_medicion, "placa"=>$vehiculo->placa, "function" => 'horom'];

            return Json::encode($val);
        }

    }

}

