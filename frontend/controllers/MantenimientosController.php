<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Mantenimientos;
use frontend\models\MantenimientosSearch;
use frontend\models\NovedadesMantenimientosSearch;
use frontend\models\OrdenesTrabajosRepuestosSearch;
use frontend\models\OrdenesTrabajosSearch;
use frontend\models\OrdenesTrabajosTrabajosSearch;
use frontend\models\PeriodicidadesTrabajos;
use frontend\models\PropiedadesTrabajos;
use frontend\models\PropiedadesTrabajosSearch;
use frontend\models\RepuestosInventariablesSearch;
use frontend\models\RepuestosProveedoresSearch;
use frontend\models\RepuestosSearch;
use frontend\models\Trabajos;
use frontend\models\TrabajosSearch;
use frontend\models\Vehiculos;
use SoapClient;
use SoapHeader;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * MantenimientosController implements the CRUD actions for Mantenimientos model.
 */
class MantenimientosController extends Controller
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
                    'index', 'view', 'create', 'update', 'delete', 'solucionar', 'cancelar'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'update'
                        ],
                        'roles' => ['p-mantenimientos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-mantenimientos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-mantenimientos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'solucionar'
                        ],
                        'roles' => ['p-mantenimientos-solucionar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'cancelar'
                        ],
                        'roles' => ['p-mantenimientos-cancelar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-mantenimientos-eliminar'],
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
     * Trabajos agrupados por tipos de Matenimientos
     */
    public function actionTrabajoTiposMantenimientos()
    {

        $searchModel = new TrabajosSearch();
        $dataProvider = $searchModel->searchTrabajoTiposMantenimientos(Yii::$app->request->queryParams);

        return $this->render('consultas/trabajo_tipos_mantenimientos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }

    /**
     * Mantenimientos agrupados por vehiculos
     */
    public function actionMantenimientoVehiculos()
    {

        $searchModel = new MantenimientosSearch();
        $dataProvider = $searchModel->searchMantenimientoVehiculos(Yii::$app->request->queryParams);

        return $this->render('consultas/mantenimiento_vehiculos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }



    /**
     * Novedades de mantenimiento
     */
    public function actionNovedadMantenimientoDias()
    {

        $searchModel = new NovedadesMantenimientosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consultas/novedad_mantenimiento_dias', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }

    /**
     * Mantenimientos Programados
     */
    public function actionProgramacionMantenimiento()
    {

        $searchModel = new MantenimientosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consultas/programacion_mantenimiento', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }

    /**
     * Trabajos asociados a una orden de trabajo
     */
    public function actionOrdenesTrabajosTrabajo()
    {

        $searchModel = new OrdenesTrabajosTrabajosSearch();
        $dataProvider = $searchModel->searchOrdenesTrabajosTrabajo(Yii::$app->request->queryParams);

        return $this->render('consultas/ordenes_trabajos_trabajo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }


    /**
     * Repuestos asociados a una orden de trabajo
     */
    public function actionOrdenesTrabajosRepuesto()
    {

        $searchModel = new OrdenesTrabajosRepuestosSearch();
        $dataProvider = $searchModel->searchOrdenesTrabajosRepuesto(Yii::$app->request->queryParams);

        return $this->render('consultas/ordenes_trabajos_repuesto', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }

    /**
     * Ordenes de Trabajos
     */
    public function actionCostoOrdenesTrabajos()
    {

        $searchModel = new OrdenesTrabajosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consultas/costo_ordenes_trabajos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }

    /**
     * Repuestos asociados a un proveedor
     */
    public function actionRepuestosProveedor()
    {

        $searchModel = new RepuestosProveedoresSearch();
        $dataProvider = $searchModel->searchRepuestosProveedor(Yii::$app->request->queryParams);

        return $this->render('consultas/repuestos_proveedor', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }

    /**
     * Repuestos asociados a una ubicacion
     */
    public function actionRepuestosInventariables()
    {

        $searchModel = new RepuestosInventariablesSearch();
        $dataProvider = $searchModel->searchRepuestosInventariables(Yii::$app->request->queryParams);

        return $this->render('consultas/repuestos_inventarios', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }

    /**
     * Repuestos con sus caracteristicas
     */
    public function actionRepuestos()
    {

        $searchModel = new RepuestosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consultas/repuestos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }

    /**
     * Trabajos Asociados por tipo de vehiculo
     */
    public function actionCostoTrabajosTipoVehiculo()
    {

        $searchModel = new PropiedadesTrabajosSearch();
        $dataProvider = $searchModel->searchCostoTrabajosTipoVehiculo(Yii::$app->request->queryParams);

        return $this->render('consultas/costo_trabajos_tipo_vehiculo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }



    /**
     * Lists all Mantenimientos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MantenimientosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Costos por Reparacion
     */
    public function actionCostoRepuestos()
    {

        $searchModel = new RepuestosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consultas/costo_repuestos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }

    /**
     * Displays a single Mantenimientos model.
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
     * Creates a new Mantenimientos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mantenimientos();

        if ($model->load(Yii::$app->request->post())) {
            $model->estado = 'Pendiente';
            if ($model->validate()) {
                $model->save();
                if ($model->save()) {
                    $medicion = $this->actionConsultaMedicion($model->vehiculo_id);
                    $medicion = Json::decode($medicion);
                    $model->almacenarMedicion($medicion, $model->vehiculo_id);
                    Yii::$app->notificador->enviarCorreoNuevaProgramacionMantenimiento($model);
                    Yii::$app->session->setFlash("success", 'Mantenimiento creado con éxito.');
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Mantenimientos model.
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
     * Deletes an existing Mantenimientos model.
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
     * Finds the Mantenimientos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mantenimientos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mantenimientos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Consulta las mediciones del Odometro o Horometro dependiendo el tipo de vehiculo
     * @param integer $idVehiculo
     * @return varchar $medicion
     */
    public function actionConsultaMedicion($idVehiculo)
    {
        $vehiculo = Vehiculos::findOne($idVehiculo);

        $username = 'wsdatumpos';
        $password = 'Ddatum_pepe123*';
        $placa = $vehiculo->placa;



        $soapURL = "http://190.143.101.58:2998/VideoData.asmx?WSDL";

        $client = new SoapClient($soapURL, array());

        $auth = array(
            'sUser' => $username,
            'sPassw' => $password,
            'sPlate' => $placa,
        );

        if ($vehiculo->tipo_medicion == 'KMS') {
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithOdometerResult', $auth, false);
            $client->__setSoapHeaders($head);


            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithOdometer($auth)->GetLastPositionWithOdometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor" => intval($value['Odometro']), "estado" => $value['NEvento'], "fecha" => $value['Fecha'], "hora" => $value['Hora'], "tipo" => $vehiculo->tipo_medicion, "placa" => $vehiculo->placa, "function" => 'odom'];

            return Json::encode($val);
        } else {
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithHorometerResult', $auth, false);
            $client->__setSoapHeaders($head);


            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithHorometer($auth)->GetLastPositionWithHorometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor" => intval($value['Horometro']), "estado" => $value['NEvento'], "fecha" => $value['Fecha'], "hora" => $value['Hora'], "tipo" => $vehiculo->tipo_medicion, "placa" => $vehiculo->placa, "function" => 'horom'];

            return Json::encode($val);
        }
    }

    public function actionCambiar($idMantenimiento)
    {
        $model = Mantenimientos::findOne($idMantenimiento);
        if($model->estado != 'Cancelado'){
        $model->estado = 'Cancelado';
        }
        else {
            $model->estado = 'Pendiente';
        }
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionSolucionar($idMantenimiento, $idVehiculo)
    {
        $model = Mantenimientos::findOne($idMantenimiento);
        $model->estado = 'Solucionado';
        $model->save();
        return $this->redirect(['ordenes-trabajos/create?idVehiculo='.$idVehiculo.'&idMantenimiento='.$idMantenimiento]);
    }

    public function actionEnviarCorreoVencimientoMantenimiento()
    {
        Yii::$app->notificador->enviarCorreoVencimientoMantenimiento();
    }

    public function actionConsultaDuracion($idVehiculo, $idTrabajo)
    {
        $vehiculo = Vehiculos::findOne($idVehiculo);
        if (!empty($idTrabajo) && !empty($idVehiculo)) {
            $propiedad = PropiedadesTrabajos::findOne(['tipo_vehiculo_id' => $vehiculo->tipo_vehiculo_id, 'trabajo_id' => $idTrabajo]);
            $data = ['duracion' => $propiedad->duracion];
            return Json::encode($data);
        } else {
            $data = ['duracion' => 'No'];
            return Json::encode($data);
        }
    }

    public function actionConsultaMedicionEjecucion($idVehiculo, $idTrabajo)
    {
        if (!empty($idTrabajo) && !empty($idVehiculo)) {
            $periodicidad = PeriodicidadesTrabajos::findOne(['vehiculo_id' => $idVehiculo, 'trabajo_id' => $idTrabajo]);
            $dato = intval($periodicidad->trabajo_normal);
            $data = ['trabajoNormal' => $dato];
            return Json::encode($data);
        } else {
            $data = ['trabajoNomal' => 'No'];
            return Json::encode($data);
        }
    }

    public function actionConsultaFecha($idVehiculo, $idTrabajo)
    {
        if (!empty($idTrabajo) && !empty($idVehiculo)) {
            $periodicidad = PeriodicidadesTrabajos::findOne(['vehiculo_id' => $idVehiculo, 'trabajo_id' => $idTrabajo, 'unidad_periodicidad' => 'Dias']);
            if ($periodicidad != null) {
                $dato = intval($periodicidad->trabajo_normal);
                $fecha = date('Y-m-d H:i');
                $fechaSumada = date("Y-m-d H:i", strtotime($fecha . '+ ' . $dato . ' days'));
                $periodicidad = PeriodicidadesTrabajos::findOne(['vehiculo_id' => $idVehiculo, 'trabajo_id' => $idTrabajo, 'unidad_periodicidad' => 'Horas']);
                if ($periodicidad != null) {
                    $dato = intval($periodicidad->trabajo_normal);
                    $fechaSumada = date("Y-m-d H:i", strtotime($fechaSumada . '+ ' . $dato . ' hours'));
                }
                $data = ['fecha' => $fechaSumada];
                return Json::encode($data);
            } else {
                $periodicidad = PeriodicidadesTrabajos::findOne(['vehiculo_id' => $idVehiculo, 'trabajo_id' => $idTrabajo, 'unidad_periodicidad' => 'Horas']);
                if ($periodicidad != null) {
                    $dato = intval($periodicidad->trabajo_normal);
                    $fecha = date('Y-m-d H:i');
                    $fechaSumada = date("Y-m-d H:i", strtotime($fechaSumada . '+ ' . $dato . ' hours'));
                    $data = ['fecha' => $fechaSumada];
                    return Json::encode($data);
                } else {
                    $data = ['fecha' => 'No'];
                    return Json::encode($data);
                }
            }
        } else {
            $data = ['fecha' => 'No'];
            return Json::encode($data);
        }
    }
}
