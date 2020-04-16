<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Mediciones;
use frontend\models\MedicionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Vehiculos;
use yii\helpers\Json;
use SoapClient;
use SoapHeader;
use yii\db\IntegrityException;
use yii\filters\AccessControl;

/**
 * MedicionesController implements the CRUD actions for Mediciones model.
 */
class MedicionesController extends Controller
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
                        'roles' => ['p-mediciones-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-mediciones-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-mediciones-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-mediciones-eliminar'],
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
     * Lists all Mediciones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MedicionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mediciones model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        /*$id = Vehiculos::find()->where(['id'=>$this->findModel($id)->vehiculo_id])->one();
        $model=$this->actionConsultaHistoricoMedicion($id, '01/01/2020');
        print_r($model);
        die();*/
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Mediciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mediciones();

        if ($model->load(Yii::$app->request->post())) {
            $valMedicionFicticio=Yii::$app->request->post()['Mediciones']['medicion'];
            $valMedicion=Yii::$app->request->post()['Mediciones']['valor_medicion'];
            
            if($valMedicionFicticio < $valMedicion){
                Yii::$app->session->setFlash("danger", 'El valor de la medicion no puede ser mayor al reportado por web service.');
                return $this->redirect(['create']);
            }else{
                $model->save();
                Yii::$app->session->setFlash("success", 'Medicion asignada con éxito.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
           
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Mediciones model.
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
     * Deletes an existing Mediciones model.
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
     * Finds the Mediciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mediciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mediciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionConsultaHistoricoMedicion($idVehiculo, $fecha)
    {
        $model2 = new Vehiculos;

        $model2 = Vehiculos::findOne($idVehiculo);
        $username = 'wsdatumpos';
        $password = 'Ddatum_pepe123*';
        $placas = $model2->placa;
        $FHInicial = date($fecha);
        $FHFinal = date('d-M-Y');
        $soapURL = "http://190.143.101.58:2998/VideoData.asmx?WSDL";

        $client = new SoapClient($soapURL, array());

        $auth = array(
            'sUsuario' => $username,
            'sClave' => $password,
            'sPlaca' => $placas,
            'sEvento' => 'encendido, estacionado',
            'sFHInicial' => $FHInicial,
            'sFHFinal' => $FHFinal
        );

            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetHistoricCustomEvents', $auth, false);
            $client->__setSoapHeaders($head);
            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetHistoricCustomEvents($auth)->GetHistoricCustomEventsResult;
            $value = json_decode($resultado, true);

            //plantear recursion para esta busqueda
            foreach($value as $key){
                if(strtotime(date($key['FHEvento']))<strtotime(date($key['FHEvento']), strtotime(date($key['FHEvento'])+'1 month'))){
                    print_r('aslkdja');
                    //almacenamiento del mayor desde que cumpla la condicion en un array
                }
                
            }
            //retornar el valor almacenado
            
            
    }

    public function actionConsultaMedicion($idVehiculo)
    {
        $model2 = new Vehiculos;

        $model2 = Vehiculos::findOne($idVehiculo);
        $username = 'wsdatumpos';
        $password = 'Ddatum_pepe123*';
        $placas = $model2->placa;



        $soapURL = "http://190.143.101.58:2998/VideoData.asmx?WSDL";

        $client = new SoapClient($soapURL, array());

        $auth = array(
            'sUser' => $username,
            'sPassw' => $password,
            'sPlate' => $placas,
        );

        if($model2->tipo_medicion == 'KMS'){
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithOdometerResult', $auth, false);
            $client->__setSoapHeaders($head);
            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithOdometer($auth)->GetLastPositionWithOdometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor"=>$value['Odometro'], "estado"=>$value['NEvento'], "fecha"=>$value['Fecha'], "hora"=>$value['Hora'], "tipo"=>$model2->tipo_medicion, "placa"=>$model2->placa, "function" => 'odom'];
            //return $val;
            return Json::encode($val);
            //return $value['Odometro'];
        }else{
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithHorometerResult', $auth, false);
            $client->__setSoapHeaders($head);
            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithHorometer($auth)->GetLastPositionWithHorometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor"=>$value['Horometro'], "estado"=>$value['NEvento'], "fecha"=>$value['Fecha'], "hora"=>$value['Hora'], "tipo"=>$model2->tipo_medicion, "placa"=>$model2->placa, "function" => 'horom'];
            //return $val;
            return Json::encode($val);
            //return $value['Odometro'];
        }  
    }

    /* 
    ** Metodo para ejecucion de Cron en el modulo de mediciones
    ** para captura automatica de mediciones.
    */
    public function actionMedicionesCron(){
        $model = new Mediciones();
        foreach(Vehiculos::find()->all() as $vehiculo){
            $medicion = $this->actionConsultaMedicion($vehiculo->id);
            $values = Json::decode($medicion);
            $model->almacenarMedicion($values, $vehiculo->id);
        }
        
    }


}
