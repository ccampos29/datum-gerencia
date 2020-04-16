<?php

namespace frontend\controllers;

use Yii;
use frontend\models\NovedadesMantenimientos;
use frontend\models\NovedadesMantenimientosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use frontend\models\Vehiculos;
use SoapClient;
use SoapHeader;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * NovedadesMantenimientosController implements the CRUD actions for NovedadesMantenimientos model.
 */
class NovedadesMantenimientosController extends Controller
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
                        'roles' => ['p-novedades-mantenimientos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-novedades-mantenimientos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-novedades-mantenimientos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-novedades-mantenimientos-eliminar'],
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
     * Lists all NovedadesMantenimientos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NovedadesMantenimientosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NovedadesMantenimientos model.
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
     * Creates a new NovedadesMantenimientos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NovedadesMantenimientos();

        if ($model->load(Yii::$app->request->post())) {
            $model->estado = 'Pendiente';
            $model->proviene_de = 'Manualmente';
            $model->validate();
            if ($model->save()) {
                $medicion = $this->actionConsultaMedicion($model->vehiculo_id);
                $medicion = Json::decode($medicion);
                $model->almacenarMedicion($medicion, $model->vehiculo_id);
                Yii::$app->notificador->enviarCorreoNuevaNovedadMantenimiento($model);
                Yii::$app->session->setFlash("success", 'Novedad creada con éxito.');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCronNovedadMantenimiento($q){
        $auth = sha1("datumgerencia123");
        if($auth == $q)
        Yii::$app->notificador->enviarCorreoVencimientoNovedadMantenimiento();
    }

    /**
     * Updates an existing NovedadesMantenimientos model.
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
     * Deletes an existing NovedadesMantenimientos model.
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
     * Finds the NovedadesMantenimientos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NovedadesMantenimientos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NovedadesMantenimientos::findOne($id)) !== null) {
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
